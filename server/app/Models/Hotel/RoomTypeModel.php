<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
class RoomTypeModel extends AdminModel
{

    public function __construct($attributes = [])
    {
        $this->table            = TABLE_HOTEL_ROOM_TYPE;
        $this->attributes       = $attributes;
        $this->_data            =  [
            'listField'         => [
                $this->table . '.id'            => 'id',
                $this->table . '.name'          => 'Tên ',
                $this->table . '.slug'          => 'Slug ',
                $this->table . '.status'        => 'Trạng thái ',
                'u.full_name AS created_by'     => 'Người tạo',
                $this->table . '.created_at'    => 'Ngày tạo',
                'u2.full_name AS updated_by'    => 'Người sửa',
                $this->table . '.updated_at'    => 'Ngày sửa',
            ],
            'fieldSearch'           => [
                $this->table . '.name'          => 'Tiêu đề',
            ],
            'button'                => ['edit', 'delete']
        ];
        parent::__construct();
    }
    public $crudNotAccepted     = ['room_name','room_name_current'];
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
            $params['created_by']       = Auth::user()->id;
            $params['created_at']       = date('Y-m-d H:i:s');
            $options['insert_id']       = self::insertGetId($this->prepareParams($params));

            if(count($params['room_name'] ?? []) > 0){
                $RoomNameModel = new RoomNameModel();
                $RoomNameModel->saveItem($params['room_name'],$options);
            }
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }

        if ($options['task'] == 'edit-item') { //cập nhật
            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');

            $this->where('id', $params['id'])->update( $this->prepareParams($params));

            $RoomNameModel              = new RoomNameModel();
            $RoomNameModel->saveItem($params['room_name_current'] ?? [],[...$options, 'insert_id' => $params['id']]);

            if(count($params['room_name'] ?? []) > 0){
                $RoomNameModel->saveItem($params['room_name'],[...$options, 'insert_id' => $params['id'], 'task' => 'add-item']);
            }

            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }
        if ($options['task'] == 'change-status') {
            $status = ($params['status'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])
                ->update([
                    'status'        => $status,
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'updated_by'    => Auth::user()->id
                ]);
        }
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item-info') {
            $result = self::select($this->table . '.*')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])
                ->with(['room_names'=>function($q){
                    $q->orderBy('created_at','desc');
                }])
                ->first();
            if ($result != null) {
                $result                     = $result->toArray();
            }
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
    public function room_names() {
        return $this->hasMany(RoomNameModel::class,'room_type_id','id');
    }
}
