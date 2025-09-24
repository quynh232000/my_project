<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PromotionModel extends AdminModel
{
    public $crudNotAccepted =['promotion', 'unlimit', 'price_types', 'room_types'];
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PROMOTION;

        $this->_data        =  [
            'listField'           => [ // liệt kê các field sẽ hiển thị ở trang danh sách theo key - value được khai báo
                $this->table . '.id'            => 'id',
                'h.name AS name_hotel'          => 'Khách sạn',
                $this->table . '.name'          => 'Tên khuyến mãi',
                $this->table . '.status'        => 'Trạng thái',
                $this->table . '.start_date'    =>' Bắt đầu',
                $this->table . '.end_date'      =>' Kết thúc',
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

        if (isset($params['hotel_id']) && $params['hotel_id'] !== "") {
            $query->where('h.id', '=', $params['hotel_id']);
        }
        if (isset($params['name']) && $params['name'] !== "") {
            $query->where($this->table . '.name', 'LIKE', '%' . $params['name'] . '%');
        }
        if (isset($params['room_type']) && $params['room_type'] !== "") {
            $query->where($this->table . '.hotel_id', $params['hotel_id'])
                    ->where('r.id', $params['room_type']);
        }
        if (isset($params['price_type']) && $params['price_type'] !== "") {
            $query->where($this->table . '.hotel_id', $params['hotel_id'])
                    ->where('p.id', $params['price_type']);
        }
        if (isset($params['start_date']) && !empty($params['start_date'])) {
            $date   = explode('-', $params['start_date']);
            $start  = str_replace(['/'], ['-'], $date[0]);
            $end    = str_replace(['/'], ['-'], $date[1]);
            $start  = date("Y-m-d H:i:s", strtotime($start));
            $end    = date("Y-m-d 23:59:59", strtotime($end));
            $query->whereBetween($this->table . '.start_date', array($start, $end));

        }
        if (isset($params['end_date']) && !empty($params['end_date'])) {
            $date   = explode('-', $params['end_date']);
            $start  = str_replace(['/'], ['-'], $date[0]);
            $end    = str_replace(['/'], ['-'], $date[1]);
            $start  = date("Y-m-d H:i:s", strtotime($start));
            $end    = date("Y-m-d 23:59:59", strtotime($end));
            $query->whereBetween($this->table . '.end_date', array($start, $end));

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

        $this->_data['status']  = false;
        if ($options['task'] == "admin-index") {
            $this->checkall     = true;
            $query = self::select(array_keys($this->_data['listField']))
                        ->selectRaw("GROUP_CONCAT(DISTINCT p.name SEPARATOR ', ') as price_type")
                        ->selectRaw("GROUP_CONCAT(DISTINCT r.name SEPARATOR ', ') as room_type")
                        ->leftJoin(TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                        ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by')
                        ->leftJoin(TABLE_HOTEL_HOTEL . ' AS h', 'h.id', '=', $this->table . '.hotel_id')
                        ->leftJoin(TABLE_HOTEL_PROMOTION_PRICE_TYPE . ' AS pt', 'pt.promotion_id', '=', $this->table . '.id')
                        ->leftJoin(TABLE_HOTEL_PRICE_TYPE . ' AS p', 'p.id', '=', 'pt.price_type_id')
                        ->leftJoin(TABLE_HOTEL_PROMOTION_ROOM_TYPE . ' AS pr', 'pr.promotion_id', '=', $this->table . '.id')
                        ->leftJoin(TABLE_HOTEL_ROOM_TYPE . ' AS r', 'r.id', '=', 'pr.room_type_id')
                        ->groupBy($this->table . '.id');

            $this->_data['listField'] = [ // liệt kê các field sẽ hiển thị ở trang danh sách theo key - value được khai báo
                    $this->table . '.id'            => 'id',
                    'h.name AS name_hotel'          => 'Khách sạn',
                    $this->table . '.name'          => 'Tên khuyến mãi',
                    'price_type'                    => 'Loại giá áp dụng',
                    'room_type'                     => 'Loại phòng áp dụng',
                    $this->table . '.start_date'    => 'Bắt đầu',
                    $this->table . '.end_date'      => 'Kết thúc',
                    $this->table . '.status'        => 'Trạng thái',
                    'u.full_name AS created_by'     => 'Người tạo',
                    $this->table . '.created_at'    => 'Ngày tạo',
                    'u2.full_name AS updated_by'    => 'Người sửa',
                    $this->table . '.updated_at'    => 'Ngày sửa',
            ];
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
        if ($options['task'] == 'add-item') { //thêm mới

            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');
            if ($params['promotion'] == 2 ) {
                $params['discount_specific_days'] = json_encode($params['discount_specific_days']);
            }else{
                $params['discount_specific_days'] = null;
            }
            $insertedId             = self::insertGetId($this->prepareParams($params));
            $params['inserted_id']  = $insertedId;
            $this->priceType        = new PromotionPriceTypeModel();
            $this->priceType->saveItem($params, ['task' => 'add-item']);
            $this->roomType         = new PromotionRoomTypeModel();
            $this->roomType->saveItem($params, ['task' => 'add-item']);

            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') { //cập nhật
            $params['inserted_id']      = $params[$this->primaryKey];
            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            $params['end_date']         = $params['end_date'] ?? null;
            if ($params['promotion'] == 2 ) {
                $params['discount_specific_days'] = json_encode($params['discount_specific_days']);
            }else{
                $params['discount_specific_days'] = null;
            }
            $this->priceType        = new PromotionPriceTypeModel();
            $this->priceType->saveItem($params, ['task' => 'edit-item']);
            $this->roomType         = new PromotionRoomTypeModel();
            $this->roomType->saveItem($params, ['task'  => 'edit-item']);
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
            $result = self::select($this->table . '.*')->with('priceType', 'roomType')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();
            if ($result != null) {
                $result['discount_specific_days']   = json_decode($result['discount_specific_days']);
                //$result                             = $result->toArray();
            }
        }
        if ($options['task'] == 'get-hotel') {
            $hotel              = new HotelModel();
            $result             = $hotel->getItem($params,['task'=>'get-all']);
        }
        if ($options['task'] == 'get-price-type') {
            $priceType          = new PriceTypeModel();
            $result             = $priceType->getItem($params,['task'=>'get-price-type']);
        }
        if ($options['task'] == 'get-all-price-type') {
            $priceType          = new PriceTypeModel();
            $result             = $priceType->getItem($params,['task'=>'get-all-price-type']);
        }
        if ($options['task'] == 'get-room-type') {
            $roomType           = new RoomTypeModel();
            $result             = $roomType->getItem($params,['task'=>'get-room-type']);
        }


        return $result;
    }
    public static function slbStatus($default = 'inactive', $params = [] )
    {
        $showDefaultOption = isset($params['action']) && $params['action'] == 'index';
        return '<select id="status" name="status" class="form-control select2 select2-danger " data-dropdown-css-class="select2-danger" style="width: 100%;">
                   ' . ($showDefaultOption ? '<option value="">Chọn trạng thái</option>' : '') . '

            <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
            <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
        </select>';
    }
    public function priceType(){
        return $this->hasMany(PromotionPriceTypeModel::class,'promotion_id');
    }
    public function roomType(){
        return $this->hasMany(PromotionRoomTypeModel::class,'promotion_id');
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {

            } else {
                $this->priceType    = new PromotionPriceTypeModel();
                $this->priceType->deleteItem($params, ['task' => 'delete-item']);
                $this->roomType     = new PromotionRoomTypeModel();
                $this->roomType->deleteItem($params, ['task' => 'delete-item']);
                self::whereIn($this->primaryKey, $params['id'])->delete();
            }
        }
    }

}
