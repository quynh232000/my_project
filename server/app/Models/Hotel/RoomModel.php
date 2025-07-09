<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use App\Http\Requests\Hotel\RoomTypeRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class RoomModel extends AdminModel
{
    public $data = [
        'room_type' => [
            'single'         => 'Phòng đơn',
            'double'         => 'Phòng đôi',
            'triple'         => 'Phòng ba',
            'quad'           => 'Phòng bốn',
        ],
        'room_direction' => [
            'sea'           => 'Hướng Biển',
            'south'         => 'Hướng Nam',
            'west'          => 'Hướng Tây',
            'east'          => 'Hướng Đông',
        ],
        'bed_type' => [
            'single'         => 'Giường đơn',
            'double'         => 'Giường đôi',
            'queen'          => 'Giường Queen',
            'king'           => 'Giường King',
        ],
        'tag_image' => [
            'phong-ngu'      => 'Phòng ngủ',
            'phong-tam'      => 'Phòng tắm',
            'ban-cong'       => 'Ban công',
        ]

    ];
    public $crudNotAccepted = ['services','images', 'list_image', 'room_type_id', 'bucket', 'image_diff', 'old_services', 'image', 'sub_bed','images_current','capacity_type'];
    public function __construct()
    {
        $this->table            = TABLE_HOTEL_ROOM;

        $this->_data            =  [
            'listField'         => [ // liệt kê các field sẽ hiển thị ở trang danh sách theo key - value được khai báo
                $this->table . '.id'            => 'id',
                $this->table . '.name'          => 'Tên ',
                $this->table . '.slug'          => 'Slug ',
                $this->table . '.status'          => 'Trạng thái ',
                'u.full_name AS created_by'     => 'Người tạo',
                $this->table . '.created_at'    => 'Ngày tạo',
                'u2.full_name AS updated_by'    => 'Người sửa',
                $this->table . '.updated_at'    => 'Ngày sửa',
            ],
            'fieldSearch'           => [ // danh sách các field sẽ tìm kiếm
                $this->table . '.name'          => 'Tiêu đề',
                // $this->table . '.slug'          => 'Slug',
            ],
            'button'                => ['edit', 'delete'] // các button cho mỗi row hiển thị( xem danh sách button trong BackenModel)
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
        if (isset($params['update_name']) && $params['update_name'] !== "all") {
            $query->where('u2.full_name', 'LIKE', '%' . $params['update_name'] . '%');
        }
        if (isset($params['name']) && $params['name'] !== "all") {
            $query->where($this->table . '.name', 'LIKE', '%' . $params['name'] . '%');
        }
        if (isset($params['base_price']) && $params['base_price'] !== "") {
            $params['base_price'] = $this->unformatNumber($params['base_price']);
            $query->where($this->table . '.base_price', 'LIKE', '%' . $params['base_price'] . '%');
        }
        if (isset($params['capacity']) && $params['capacity'] !== "") {
            $query->where($this->table . '.capacity',  $params['capacity']);
        }
        if (isset($params['hotel_id']) && $params['hotel_id'] !== "") {
            $query->where($this->table . '.hotel_id', '=', $params['hotel_id']);
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
            dd($params);
            $params['code']             = now();
            $params['created_by']       = Auth::user()->id;
            $params['created_at']       = date('Y-m-d H:i:s');
            $params['price_min']        = $this->unformatNumber($params['price_min']) ?? '';
            $params['price_max']        = $this->unformatNumber($params['price_max']) ?? '';
            $params['price_standard']   = $this->unformatNumber($params['price_standard']) ?? '';
            isset($params['special_service']) ? $params['special_service'] = json_encode($params['special_service']) : '';
            if ($params['allow_children'] == 1) {
                $params['max_capacity'] = $params['standard_capacity'] + $params['add_adt'] ?? $params['add_chd'];
            }

            // $params['fee_extra_bed']    = json_encode($params['fee_extra_bed'] ?? '');
            $params['room_type_id']     = self::insertGetId($this->prepareParams($params));
            $roomServiceModel           = new HotelServiceModel();
            $roomServiceModel->saveItem($params,['task'=>'add-room-service']);
            //--save image--
            if (request()->hasFile('images.image')) {
                $this->HotelAbumnModel  = new HotelAbumnModel();
                $this->HotelAbumnModel->saveItem($params,['task' => 'add-room-img']);
            }

            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }

        if ($options['task'] == 'edit-item') { //cập nhật
            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            $params['bucket']           = 's3_' . $params['prefix'];
            $params['room_type_id']     = $params['id'];
            $params['price_min']        = $this->unformatNumber($params['price_min']) ?? '';
            $params['price_max']        = $this->unformatNumber($params['price_max']) ?? '';
            $params['price_standard']   = $this->unformatNumber($params['price_standard']) ?? '';
            isset($params['special_service']) ? $params['special_service'] = json_encode($params['special_service']) : '';
            if ($params['capacity_type'] == 1) {
                $params['max_capacity'] = $params['standard_capacity'] + $params['add_adt'] ?? $params['add_chd'];
            }
            $params['services']         = $params['services'] ?? [];
            $this->roomService          = new HotelServiceModel();
            $this->roomService->saveItem($params,['task' => 'edit-room-service']);

            $imageDelete                = $params['list_image'] ? json_decode($params['list_image']) : [];
            $HotelAbumnModel            = new HotelAbumnModel();
            if (count($imageDelete) > 0){
                $HotelAbumnModel->deleteItem($imageDelete,['task' => 'delete-room-img']);
            }
            $HotelAbumnModel->saveItem($params,['task' => 'edit-room-img']);
            if(count($params['images_current'] ?? []) > 0){
                $HotelAbumnModel->saveItem($params['images_current'],['task' => 'update-name-image']);
            }

            $this->where($this->primaryKey, $params[$this->primaryKey])
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
                $result                     = $result->toArray();
                $result['special_service']  = json_decode($result['special_service']);
                $result['content']          = '';
                $params['item']             = $result;
                $this->roomImage            = new HotelAbumnModel();
                $result['images']           = $this->roomImage->getItem($params, ['task' => 'get-room-image']);
                $this->roomService          = new HotelServiceModel();
                $result['services']         = $this->roomService->getItem($params, ['task' => 'get-room-service']);
            }
        }
        if ($options['task'] == 'get-all') {

            $result = self::select('id','hotel_id','name')->with('hotel:id,name')->get();
        }
        if ($options['task'] == 'get-hotel') {

            $hotel  = new HotelModel();
            $result = $hotel->listItem($params, ['task' => 'get-all']);
        }
        if ($options['task'] == 'get-room-service') {
            $service    = new ServiceModel();
            $result     = $service->getItem($params, ['task' => 'get-room-service']);
        }
        if ($options['task'] == 'get-room-type') {
            $result     = self::select('id', 'name')->where([$this->table . '.hotel_id' => $params['hotel_id']])->get();
        }

        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {

            } else {
                $params['bucket']       = 's3_' . $params['prefix'];
                $this->roomImage        = new HotelAbumnModel();
                $params['image_diff']   = $this->roomImage->listItem($params, ['task' => 'room-image']);
                $this->roomImage->deleteItem($params, ['task' => 'delete-room-img']);
                self::whereIn($this->primaryKey, $params['id'])->delete();
            }
        }
    }
    public static function slbStatus($default = 'inactive',$params = [])
    {
        $showDefaultOption = isset($params['action']) && $params['action'] == 'index';
        $default = isset($params['item']['status']) ? $params['item']['status'] : '';
        return '<select id="status" name="status" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                   ' . ($showDefaultOption ? '<option value="" selected>Chọn trạng thái</option>' : '') . '

        <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
            <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
        </select>';
    }
    public function columnBase_price($params, $field, $val){

        return number_format($val[$field], 0, ',', '.');
    }
    protected function unformatNumber($value)
    {
        return str_replace('.', '', $value);
    }
    public function hotel(){
        return $this->belongsTo(HotelModel::class,'hotel_id','id');
    }
    public function priceTypes()
    {
        return $this->belongsToMany(PriceTypeModel::class, TABLE_HOTEL_ROOM_PRICE_TYPE, 'room_type_id', 'price_type_id');
    }
    // public function priceRules(){
    //    return $this->hasMany(PriceRuleModel::class , 'room_type_id');
    // }
    public static function selectOptions($name, $type, $selected = null){
        $parent     = AttributeModel::select('id')->where('slug',$type)->first();
        $data       = AttributeModel::select('id','name')
                                    ->where('parent_id',$parent->id ?? '')
                                    ->get()
                                    ->toArray();
        $opts       = '';
        foreach ($data as $item){
            $opts   .= '<option value="'.$item['id'].'" '.($selected == $item['id']?'selected':'').'>'.$item['name'].'</option>';
        }
        return '
            <select class="form-control select2 select2-primary" id="'.$name.'" data-dropdown-css-class="select2-primary"  name="'.$name.'">
                <option value="">-- Chọn --</option>
                '.$opts.'
            </select>
        ';
    }
    public static function selectImageLabel($default = null,$name = 'image_name[other][]',$dataOld = null){
        $parent     = AttributeModel::select('id')->where('slug','image_type')->first();
        $data       = AttributeModel::select('id','name')
                                    ->where('parent_id',$parent->id)
                                    ->get()
                                    ->toArray();
        $opts       = '';
        foreach ($data as $item){
            $opts   .= '<option value="'.$item['id'].'" '.($default==$item['id']?'selected':'').'>'.$item['name'].'</option>';
        }
        return '
            <select class="form-control select2 select2-primary image_name" data-old="'.$dataOld.'" data-dropdown-css-class="select2-primary"  name="'.$name.'">
                <option value="">-- Chọn --</option>
                '.$opts.'
            </select>
        ';
    }
    public static function selectAge($default = null,$name = 'image_name[other][]'){
        $parent     = AttributeModel::select('id')->where('slug','image_type')->first();
        $data       = AttributeModel::select('id','name')
                                    ->where('parent_id',$parent->id)
                                    ->get()
                                    ->toArray();
        $opts       = '';
        foreach ($data as $item){
            $opts   .= '<option value="'.$item['id'].'" '.($default==$item['id']?'selected':'').'>'.$item['name'].'</option>';
        }
        return '
            <select class="form-control select2 select2-primary image_name" data-dropdown-css-class="select2-primary"  name="'.$name.'">
                <option value="">-- Chọn --</option>
                '.$opts.'
            </select>
        ';
    }
    public function setFee_extra_bedAttribute($value)
    {
        $this->attributes['fee_extra_bed'] = json_encode($value);
    }

}
