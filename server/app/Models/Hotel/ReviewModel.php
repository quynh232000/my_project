<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ReviewModel extends AdminModel
{
    public $data = [
        'type'      => ['Kỳ nghỉ ngắn', 'Nghỉ dưỡng', 'Công tác', 'Kỳ nghỉ gia đình', 'Du lịch',],
        'quality'   => [
            0 =>  'Sạch sẽ',
            1 =>  'Thoải mái',
            2 =>  'Đồ ăn',
            3 =>  'Vị trí',
            4 =>  'Giá cả',
        ],
    ];
    public $crudNotAccepted = ['images', 'slug', 'listImage', 'image_name'];
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_REVIEW;

        $this->_data        =  [
            'listField'           => [
                $this->table . '.id'            => 'id',
                'h.name AS hotel_id'            => 'Khách sạn',
                $this->table . '.username'      => 'Người đánh giá',
                $this->table . '.point'         => 'Điểm đánh giá',
                $this->table . '.status'        => 'Trạng thái',
                'u.full_name AS created_by'     => 'Người tạo',
                $this->table . '.created_at'    => 'Ngày tạo',
                'u2.full_name AS updated_by'    => 'Người sửa',
                $this->table . '.updated_at'    => 'Ngày sửa',
            ],
            'button'                => ['edit', 'delete']
        ];
        parent::__construct();
    }
    public function adminQuery(&$query, $params)
    {

        if (isset($params['created_by']) && $params['created_by'] !== "") {
            $created_by = explode(',', preg_replace('/\s+/', ',', $params['created_by']));
            $created_by = array_filter($created_by, 'strlen');
            $query->whereIn($this->table . '.created_by', $created_by);
        }
        if (isset($params['full_name']) && $params['full_name'] !== "all") {
            $query->where('u.full_name', 'LIKE', '%' . $params['full_name'] . '%');
        }
        if (isset($params['type']) && $params['type'] !== "") {
            $query->whereRaw("JSON_CONTAINS(`type`, ?)", [json_encode([$params['type']])]);
        }

        if (isset($params['hotel_id']) && $params['hotel_id'] !== "") {
            $query->where('h.id', '=', $params['hotel_id']);
        }

        if (isset($params['created_at']) && !empty($params['created_at'])) {
            $date   = explode('-', $params['created_at']);
            $start  = str_replace(['/'], ['-'], $date[0]);
            $end    = str_replace(['/'], ['-'], $date[1]);
            $start  = date("Y-m-d H:i:s", strtotime($start));
            $end    = date("Y-m-d 23:59:59", strtotime($end));

            $query->whereBetween($this->table . '.created_at', array($start, $end));

        }
        if (isset($params['updated_at']) && !empty($params['updated_at'])) {
            $date   = explode('-', $params['updated_at']);
            $start  = str_replace(['/'], ['-'], $date[0]);
            $end    = str_replace(['/'], ['-'], $date[1]);
            $start  = date("Y-m-d H:i:s", strtotime($start));
            $end    = date("Y-m-d 23:59:59", strtotime($end));

            $query->whereBetween($this->table . '.updated_at', array($start, $end));

        }

        if (isset($params['status']) && $params['status'] != "") {
            $query->where($this->table . '.status', '=', $params['status']);
        }

        return $query;
    }
    public function listItem($params = null, $options = null)
    {

        $this->_data['status'] = false;
        if ($options['task'] == "admin-index") {
            $this->checkall   = true;
            $query                          = self::select(array_keys($this->_data['listField']))
                ->leftJoin(TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                ->leftJoin(TABLE_HOTEL_HOTEL . ' AS h', 'h.id', '=',  $this->table . '.hotel_id')
                ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by');

            $query                          = self::adminQuery($query, $params);

            $sortBy                         = isset($params['sort']) && !empty($params['sort']) ? str_replace('-', '_', $params['sort']) : $this->table . '.' . $this->primaryKey;
            $orderBy                        = isset($params['order']) && !empty($params['order']) ? $params['order'] : 'DESC';

            $this->_data['items']           =  $query->orderBy($sortBy, $orderBy)->paginate($params['item-per-page']);

            $this->_data['headTable']       = $this->headTable($this->_data['listField']);
            $this->_data['contentHtml']     = $this->contentHtml($params, $this->_data);
            $this->_data['status']          = true;

            unset($this->_data['headTable']);
        }
        return $this->_data;
    }
    public function saveItem($params = null, $options = null)
    {

        if ($options['task'] == 'add-item') { //thêm mới
            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');
            isset($params['type'])      != null ? $params['type']       = json_encode($params['type']) : '';
            isset($params['qualities']) != null ? $params['qualities']  = json_encode($params['qualities']) : '';
            $insertedId             = self::insertGetId($this->prepareParams($params));
            $folderPath             = $params['controller'] . '/images/' . $insertedId . '/';
            $params['bucket']       = 's3_' . $params['prefix'];
            $params['inserted_id']  = $insertedId;
            if (request()->hasFile('images.review')) {
                $this->hotel        = new HotelModel();
                $params['hotel_slug']   = $this->hotel->getItem($params['hotel_id'], ['task' => 'get-slug-by-id']);
                $this->reviewImage  = new ReviewImageModel();
                $this->reviewImage->saveItem($params, ['task' => 'add-item']);
            }
            if (request()->hasFile('images.user')) {
                $image            = $params['images']['user'];
                $imageName        = $params['slug'] . '-' . time() . '.' . $image->extension();
                Storage::disk( $params['bucket'])->put($folderPath . $imageName, file_get_contents($image));
                $params['image']  = $imageName;
                $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
                unset($params['bucket'], $params['inserted_id'], $params['hotel_slug']);
                $this->where($this->primaryKey, $insertedId)
                    ->update($this->prepareParams($params));
            }
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') { //cập nhật
            $params['inserted_id']      = $params[$this->primaryKey];
            $folderPath                 = $params['controller'] .'/images/' . $params[$this->primaryKey] . '/';
            $params['bucket']           = 's3_' . $params['prefix'];

            if ($params['listImage']){
                $this->reviewImage      = new ReviewImageModel();
                $listItem               = $this->reviewImage->listItem($params, ['task' => 'list-image']);
                $params['imageDiff']    = array_diff($listItem, json_decode( $params['listImage']));
                if ($params['imageDiff'] != null) {
                    $this->reviewImage->deleteItem($params,['task' => 'delete-item']);
                }
            }
            if (request()->hasFile('images.review')) {
                $this->hotel            = new HotelModel();
                $params['hotel_slug']   = $this->hotel->getItem($params['hotel_id'], ['task' => 'get-slug-by-id']);
                $this->reviewImage      = new ReviewImageModel();
                $this->reviewImage->saveItem($params, ['task' => 'add-item']);
            }
            if (request()->hasFile('images.user')) {
                isset($params['image_name']) ? $oldImage = $params['image_name'] : $oldImage = '';
                if ($oldImage) {
                    Storage::disk(  $params['bucket'])->delete($folderPath . $oldImage);
                    Storage::disk(  $params['bucket'])->delete($folderPath . '/thumb1/'   . $oldImage);
                }
                $image                  = $params['images']['user'];
                $imageName              = $params['slug'] . '-' . time() . '.' . $image->extension();
                Storage::disk($params['bucket'])->put($folderPath . $imageName, file_get_contents($image));
                $params['image']        = $imageName;
                $params['inserted_id']  = $params['id'];
                $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
            }

            unset($params['bucket'], $params['inserted_id'], $params['hotel_slug']);
            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            self::findOrFail($params['id'])->update($this->prepareParams($params));
            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }
        if ($options['task'] == 'change-status') {
            $status = ($params['status'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])
                ->update([
                    'status'     => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
        }
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item-info') {

            $result = self::select($this->table . '.*')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();
            if ($result != null) {

                $result               = $result->toArray();
                $result['nameImage']  = $result['image'];
                $result['qualities']  = json_decode($result['qualities'], true);
                $result['image']      = $this->getImageUrlS3($result['image'], $params);
                $this->reviewImage    = new ReviewImageModel();
                $result['images']     = $this->reviewImage->listItem( $params, ['task' => 'list-review-image']);
            }
        }
        if ($options['task'] == 'get-hotel') {
            $result     = HotelModel::select('id','name')->where(['status'=>'active'])->orderBy('created_at','desc')->get();
        }
        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {

            } else {
                self::whereIn($this->primaryKey, $params['id'])->delete();
            }
        }
    }
    public static function slbStatus($default = 'inactive', $params = [] )
    {
        $showDefaultOption = isset($params['action']) && $params['action'] == 'index';
        $default = isset($params['item']['status']) ? $params['item']['status'] : '';

        return '<select id="status" name="status" class="form-control select2 select2-danger " data-dropdown-css-class="select2-danger" style="width: 100%;">
                   ' . ($showDefaultOption ? '<option value="">Chọn trạng thái</option>' : '') . '

            <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
            <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
        </select>';
    }
    public function getImageUrlS3($fileName, $params)
    {
        $filePath = $params['controller'] .'/images/'. $params['id'] .'/'. $fileName;
        return Storage::disk('s3_'.$params['prefix'])->url($params['prefix'] .'/'. $filePath);
    }
}
