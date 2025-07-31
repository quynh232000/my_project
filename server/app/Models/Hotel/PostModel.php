<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Hotel\PostCategoryIdModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PostModel extends AdminModel
{
    protected $path;
    public $crudNotAccepted = ['image_name'];
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_POST;

        $this->_data        =  [
            'listField'           => [ // liệt kê các field sẽ hiển thị ở trang danh sách theo key - value được khai báo
                $this->table . '.id'            => 'id',
                $this->table . '.name'          => 'Tiêu đề',
                $this->table . '.slug'          => 'Slug',
                // 'c.name AS category_name'       => 'Danh mục',
                $this->table . '.status'        => 'Trạng thái',

                'u.full_name AS created_by'     => 'Người tạo',
                $this->table . '.created_at'    => 'Ngày tạo',
                'u2.full_name AS updated_by'    => 'Người sửa',
                $this->table . '.updated_at'    => 'Ngày sửa',
            ],
            'fieldSearch'           => [ // danh sách các field sẽ tìm kiếm
                $this->table . '.name'          => 'Tiêu đề',
                $this->table . '.slug'          => 'Slug',
            ],
            'button'                => ['edit', 'delete'] // các button cho mỗi row hiển thị( xem danh sách button trong BackenModel)
        ];
        parent::__construct();
    }
    public function adminQuery(&$query, $params)
    {

        if (isset($params['code']) && $params['code'] !== "") {
            $code = explode(',', preg_replace('/\s+/', ',', $params['code']));
            $code = array_filter($code, 'strlen');
            $query->whereIn($this->table . '.code', $code);
        }
        if (isset($params['created_by']) && $params['created_by'] !== "") {
            $created_by = explode(',', preg_replace('/\s+/', ',', $params['created_by']));
            $created_by = array_filter($created_by, 'strlen');
            $query->whereIn($this->table . '.created_by', $created_by);
        }
        if (isset($params['full_name']) && $params['full_name'] !== "all") {
            $query->where('u.full_name', 'LIKE', '%' . $params['full_name'] . '%');
        }
        if (isset($params['update_name']) && $params['update_name'] !== "all") {
            $query->where('u2.full_name', 'LIKE', '%' . $params['update_name'] . '%');
        }
        if (isset($params['name']) && $params['name'] !== "all") {
            $query->where($this->table . '.name', 'LIKE', '%' . $params['name'] . '%');
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
                // ->leftJoin(TABLE_HOTEL_POST_CATEGORY . ' AS c', 'c.category_id', '=', $this->table . '.id')
                ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by');

            $query                          = self::adminQuery($query, $params);

            $sortBy                         = isset($params['sort']) && !empty($params['sort']) ? str_replace('-', '_', $params['sort']) : $this->table . '.' . $this->primaryKey;
            $orderBy                        = isset($params['order']) && !empty($params['order']) ? $params['order'] : 'DESC';

            $this->_data['items']           =  $query->orderBy($sortBy, $orderBy)->paginate($params['item-per-page']);

            $this->_data['headTable']       = $this->headTable($this->_data['listField']);
            $this->_data['contentHtml']     = $this->contentHtml($params, $this->_data);
            $this->_data['status']          = true;
            // unset($this->_data['items']);
            unset($this->_data['headTable']);
        }
        return $this->_data;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
            $params['created_by']       = Auth::user()->id;
            $params['created_at']       = date('Y-m-d H:i:s');

            if (request()->hasFile('image')) {
                $params['image'] = FileService::file_upload($params, $params['image'], 'image');
            }
            self::insertGetId($this->prepareParams($params));


            return response()->json(['success' => true, 'msg' => 'Tạo yêu cầu thành công!']);
        }

        if ($options['task'] == 'edit-item') { //cập nhật

            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');

            if (request()->hasFile('image')) {
                $params['image'] = FileService::file_upload($params, $params['image'], 'image');
            }
            $this->where('id', $params['id'])
                ->update(
                    $this->prepareParams($params)
                );
            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }
        if ($options['task'] == 'change-status') {
            $status = ($params['status'] == "active") ? "inactive" : "active";

            self::where('id', $params['id'])
                ->update([
                    'status'    => $status,
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
                $result                 = $result->toArray();
                $params['item']         = $result;
                $result['imageName']    = $result['image'];
                $result['status']       = trim($result['status']);
            }
        }
        if ($options['task'] == 'get-category-info') {
            $result = self::select($this->table . '.*')->with('categories:id')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();
        }
        return $result;
    }

    public static function slbStatus($default = 'inactive', $params = [])
    {
        $showDefaultOption = isset($params['action']) && $params['action'] == 'index';
        // $default = isset($params['item']['status']) ? $params['item']['status'] : 'inactive';

        return '<select id="status" name="status" class="form-control " data-control="select2" style="width: 100%;">
                   ' . ($showDefaultOption ? '<option value="" selected>Chọn trạng thái</option>' : '') . '

        <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
            <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
        </select>';
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {
            } elseif (is_array($params['id'])) {
                $PostCategoryIdModel = new PostCategoryIdModel();
                $PostCategoryIdModel->deleteItem($params, ['task' => 'delete-item']);
                self::whereIn($this->primaryKey, $params['id'])->whereNotIn('status', ['finish', 'pending-print', 'signed'])->delete();
            }
        }
    }
    public function categories()
    {

        return $this->belongsToMany(PostCategoryModel::class, TABLE_HOTEL_POST_CATEGORY_ID, 'post_id', 'category_id');
    }
    private function saveImageS3($params, $options)
    {
        $params['bucket']       = 's3_' . $params['prefix'];
        if ($options['task'] == 'add-item') {
            $insertedId             = $params['inserted_id'];
            $folderPath             =  $params['controller'] . '/images/' . $params['inserted_id'] . '/';
            $image                  = $params['image'];
            $imageName              = $params['slug'] . '.' . $image->extension();
            Storage::disk($params['bucket'])->put($folderPath . $imageName, file_get_contents($image));
            $params['image']        = $imageName;
            $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
            unset($params['bucket'], $params['inserted_id'], $params['category_id']);
            $this->where($this->primaryKey, $insertedId)
                ->update($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') {
            $oldImage               = $params[$this->primaryKey];
            $folderPath             = $params['controller'] . '/images/' . $oldImage . '/';
            if ($oldImage) {
                Storage::disk($params['bucket'])->delete($folderPath . $params['image_name']);
                Storage::disk($params['bucket'])->delete($folderPath . '/thumb1/'   . $params['image_name']);
            }
            $image                  = $params['image'];
            $imageName              = $params['slug'] . '.' . $image->extension();
            Storage::disk($params['bucket'])->put($folderPath . $imageName, file_get_contents($image));
            $params['image']        = $imageName;
            $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
            unset($params['bucket'], $params['inserted_id']);
            return $params;
        }
    }
    public static function treeSelectCategory($categories, $selected_id = null)
    {
        $xhtml = '';
        foreach ($categories as $category) {
            if ($categories instanceof Collection) {
                $selected = $selected_id && $selected_id->contains($category->id) == true ? 'selected' : '';
            } else {
                $selected = $selected_id && $selected_id == $category['id'] ? 'selected' : '';
            }
            $xhtml .= '<option ' . $selected . ' value="' . $category['id'] . '">' . str_repeat('--', $category['depth']) . $category['name'] . '</option>';
        }
        return $xhtml;
    }
}
