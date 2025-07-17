<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PriceTypeModel extends AdminModel
{
    public $crudNotAccepted = ['additional_fee', 'all_room_types', 'room_type_id', 'refund_policy'];
    protected $guarded = ['id'];
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_TYPE;
        $this->_data        =  [
            'listField'           => [ // liệt kê các field sẽ hiển thị ở trang danh sách theo key - value được khai báo
                $this->table . '.id'            => 'id',
                'h.name AS hotel_name'          => 'Khách sạn',
                $this->table . '.name'          => 'Tên loại giá',
                $this->table . '.status'        => 'Trạng thái',
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
        if (isset($params['hotel_id']) && $params['hotel_id'] !== "") {
            $query->where('h.id', '=', $params['hotel_id']);
        }
        if (isset($params['name']) && $params['name'] !== "all") {
            $query->where($this->table . '.name', 'LIKE', '%' . $params['name'] . '%');
        }
        if (isset($params['room_type']) && $params['room_type'] !== "") {
            $query->where($this->table . '.hotel_id', $params['hotel_id'])
                    ->where('r.id', $params['room_type']);
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
            $query            = self::select(array_keys($this->_data['listField']))
                ->selectRaw("GROUP_CONCAT(DISTINCT r.name SEPARATOR ', ') as room_type")
                ->leftJoin(TABLE_HOTEL_HOTEL . ' AS h', 'h.id', '=', $this->table . '.hotel_id')
                ->leftJoin(TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by')
                ->leftJoin(TABLE_HOTEL_ROOM_PRICE_TYPE . ' AS rt', 'rt.price_type_id', '=', $this->table . '.id')
                ->leftJoin(TABLE_HOTEL_ROOM_TYPE . ' AS r', 'r.id', '=', 'rt.room_type_id')
                ->groupBy($this->table . '.id');
            $this->_data['listField'] = [ // liệt kê các field sẽ hiển thị ở trang danh sách theo key - value được khai báo
                $this->table . '.id'            => 'id',
                'h.name AS hotel_name'          => 'Khách sạn',
                $this->table . '.name'          => 'Tên loại giá',
                'room_type'                     => 'Loại phòng',
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
    public function getItem($params = null, $options = null){
        $result = null;

        if ($options['task'] == 'get-item-info') {
            $result = self::select($this->table . '.*')->with( 'roomType')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();
            if ($result != null) {
                //$result                            = $result->toArray();
            }
        }
        if ($options['task'] == 'get-all-price-type') {
            $result     = self::select($this->table . '.id', $this->table . '.name')->get()->unique('name');
        }
        if ($options['task'] == 'get-price-type') {

            $result     = self::select('id', 'name')->where($this->table . '.hotel_id', $params['hotel_id'])->get();
        }
        if ($options['task'] == 'get-hotel') {
            $hotel      = new HotelModel();
            $result     = $hotel->listItem($params,['task'=>'get-all']);
        }
        if ($options['task'] == 'get-room-type') {
            $roomType   = new RoomTypeModel();
            $result     = $roomType->getItem($params,['task'=>'get-room-type']);
        }
        return $result;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') { //thêm mới
            $params['created_by']       = Auth::user()->id;
            $params['created_at']       = date('Y-m-d H:i:s');
            isset($params['adt_fees']) ? $params['adt_fees'] =  $this->unformatNumber($params['adt_fees']) : '';
            $insertedId                 = self::insertGetId($this->prepareParams($params));
            $params['inserted_id']      = $insertedId;
            $this->priceType            = new RoomPriceTypeModel();
            $this->priceType->saveItem($params, ['task' => 'add-item']);

            $this->tablePrice           = new DateBasedPriceModel();
            $this->tablePrice->saveItem($params, ['task' => 'add-item']);

            $this->priceRule            = new PriceRuleModel();
            $this->priceRule->saveItem($params, ['task' => 'add-item']);

            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') { //cập nhật

            $params['inserted_id']      = $params[$this->primaryKey];
            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            if ($params['additional_fee'] != 1) {
                $params['adt_fees'] = null;
            }
            isset($params['adt_fees']) ? $params['adt_fees'] =  $this->unformatNumber($params['adt_fees']) : '';
            $this->roomType             = new RoomPriceTypeModel();
            $this->roomType->saveItem($params, ['task'  => 'edit-item']);

            $this->tablePrice           = new DateBasedPriceModel();
            $this->tablePrice->saveItem($params, ['task' => 'add-item']);

            $this->priceRule            = new PriceRuleModel();
            $this->priceRule->saveItem($params, ['task' => 'add-item']);

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
    protected function unformatNumber($value)
    {
        return str_replace('.', '', $value);
    }
    public static function slbStatus($default = 'inactive', $params = [] )
    {
        $showDefaultOption = isset($params['action']) && $params['action'] == 'index';
        //$default = isset($params['item']['status']) ? $params['item']['status'] : 'inactive';

        return '<select id="status" name="status" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                   ' . ($showDefaultOption ? '<option value="" selected>Chọn trạng thái</option>' : '') . '

        <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
            <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
        </select>';
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {

            } else {
                $this->roomType     = new RoomPriceTypeModel();
                $this->roomType->deleteItem($params, ['task' => 'delete-item']);
                self::whereIn($this->primaryKey, $params['id'])->delete();
            }
        }
    }
    public function roomType(){
        return $this->hasMany(RoomPriceTypeModel::class,'price_type_id');
    }
    // Quan hệ N:N với RoomType qua bảng phụ room_price_types
    // public function roomTypes()
    // {
    //     return $this->belongsToMany(RoomTypeModel::class, TABLE_HOTEL_ROOM_PRICE_TYPE, 'price_type_id', 'room_type_id');
    // }
    // Quan hệ 1:N với DateBasedPrice qua bảng date_based_prices
    // public function dateBasedPrices()
    // {
    //     //return $this->belongsToMany(DateBasedPriceModel::class, TABLE_HOTEL_ROOM_PRICE_TYPE, 'price_type_id', 'room_type_id',);
    //     return $this->belongsTo(DateBasedPriceModel::class, 'price_type_id','room_type_id');
    //     //return $this->hasManyThrough(DateBasedPriceModel::class, RoomTypeModel::class, 'price_type_id', 'room_type_id');
    //     //return $this->hasManyThrough(DateBasedPriceModel::class, RoomTypeModel::class, 'price_type_id', 'room_type_id', 'id', 'id');

    // }
    public function roomTypes()
    {
        return $this->belongsToMany(RoomTypeModel::class, TABLE_HOTEL_ROOM_PRICE_TYPE, 'price_type_id', 'room_type_id');
    }

    public function dateBasedPricings()
    {
        return $this->hasMany(DateBasedPriceModel::class, 'price_type_id');
        //return $this->belongsToMany(DateBasedPriceModel::class, TABLE_HOTEL_ROOM_TYPE, 'room_type_id', 'id');
    }
    public function priceRules(){
        return $this->hasMany(PriceRuleModel::class , 'price_type_id');
     }
}
