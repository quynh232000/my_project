<?php

namespace App\Models\Hotel;
use App\Models\AdminModel;
use App\Models\General\CityModel;
use App\Models\General\CountryModel;
use App\Models\General\DistrictModel;
use App\Models\General\WardModel;
use Auth;
use Illuminate\Support\Facades\Storage;

class PriorityModel extends AdminModel
{
    protected $guarded = ['id'];

    public function __construct($attributes = [])
    {
        $this->table        = TABLE_HOTEL_PRIORITY;
        $this->attributes   = $attributes;

        $this->_data        =  [
            'listField'     => [
                $this->table . '.id'            => 'id',
                'h.name AS hotel_id'            => 'Tên khách sạn',
                $this->table . '.priority'      => 'Độ ưu tiên',
                'ca.name AS category_id'        => 'Danh mục',
                'country.name AS country_id'    => 'Quốc gia',
                'city.name AS city_id'          => 'Thành phố',
                'district.name AS district_id'  => 'Quận/Huyện',
                'ward.name AS ward_id'          => 'Phường/Xã',
                $this->table . '.address'       => 'Địa chỉ',
                $this->table . '.status'        => 'Trạng thái',
                'u.full_name AS created_by'     => 'Người tạo',
                $this->table . '.created_at'    => 'Ngày tạo',
                'u2.full_name AS updated_by'    => 'Người sửa',
                $this->table . '.updated_at'    => 'Ngày sửa',
            ],
            'fieldSearch'           => [
                $this->table . '.name'          => 'Tiêu đề',
            ],
            'button'                            => ['edit', 'delete']
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
        if (isset($params['type']) && $params['type'] !== "") {
            $query->where($this->table . '.type', '=', $params['type']);
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

        $arrayAcceptFilter = ['status','hotel_id','category_id','country_id','city_id','district_id','ward_id'];

        foreach ($arrayAcceptFilter as $item) {
            if (isset($params[$item]) && $params[$item] != "") {
                $query->where($this->table . '.'. $item, '=', $params[$item]);
            }
        }
        if (isset($params['address']) && $params['address'] !== "") {
            $query->where($this->table . '.address', 'LIKE', '%' . $params['address'] . '%');
        }

        return $query;
    }
    public function listItem($params = null, $options = null){
        $this->_data['status'] = false;
        if ($options['task'] == "admin-index") {
            $this->checkall   = true;
            $query                          = self::select([...array_keys($this->_data['listField']),
                                            $this->table.'.is_country',
                                            $this->table.'.is_city',
                                            $this->table.'.is_district',
                                            $this->table.'.is_ward'
                                            ])
                                            ->leftJoin(TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                                            ->leftJoin(TABLE_HOTEL_HOTEL . ' AS h', 'h.id', '=', $this->table . '.hotel_id')
                                            ->leftJoin(TABLE_HOTEL_HOTEL_CATEGORY . ' AS ca', 'ca.id', '=', $this->table . '.category_id')
                                            ->leftJoin(TABLE_GENERAL_COUNTRY . ' AS country', 'country.id', '=', $this->table . '.country_id')
                                            ->leftJoin(TABLE_GENERAL_CITY . ' AS city', 'city.id', '=', $this->table . '.city_id')
                                            ->leftJoin(TABLE_GENERAL_DISTRICT . ' AS district', 'district.id', '=', $this->table . '.district_id')
                                            ->leftJoin(TABLE_GENERAL_WARD . ' AS ward', 'ward.id', '=', $this->table . '.ward_id')
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
    public function getItem($params = null, $options = null){

        $result     = null;
        if ($options['task'] == 'get-item-info') {
           $result  = self::find($params['id']);
        }
        return $result;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {

            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');
            $params['priority']     = $params['priority'] ?? 9999;

            $id                     = self::insertGetId($this->prepareParams($params));

            return response()->json(['success' => true, 'message' => 'Tạo yêu mới cầu thành công!','id' => $id]);
        }
        if ($options['task'] == 'edit-item'){
            $params['updated_by']   = Auth::user()->id;
            $params['updated_at']   = date('Y-m-d H:i:s');
            $params['priority']     = $params['priority'] ?? 9999;

            $params['is_country']   = $params['is_country'] ?? 0;
            $params['is_city']      = $params['is_city'] ?? 0;
            $params['is_district']  = $params['is_district'] ?? 0;
            $params['is_ward']      = $params['is_ward'] ?? 0;

            self::where('id', $params['id'])->update($this->prepareParams($params));

            return response()->json(['success' => true, 'message' => 'Cập nhật yêu cầu thành công!']);
        }
        if ($options['task'] == 'change-status') {
            $status = ($params['status'] == "active") ? 'inactive' : 'active';
            self::where($this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])
                ->update([
                    'status'     => $status,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
        }
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] != '0') {
                self::whereIn($this->primaryKey, $params['id'])->delete();
            }
        }
    }
     public static function slbStatus($default = null, $params = [])
    {
        return '<select class="form-select mb-2" id="status" data-control="select2" name="status"
                        data-placeholder="Select an option" data-allow-clear="true">
                   ' . (!$default ? '<option value="" selected>--Select--</option>' : '') . '
                     <option value="active" ' . ($default == "active" ? "selected" : "") . '>Active</option>
                    <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Inactive</option>
                </select>';
    }
    public static function dataType(){
        return  [
            'category'  => 'Danh mục',
            'country'   => 'Quốc gia',
            'city'      => 'Thành phố',
            'district'  => 'Quận/Huyện',
            'ward'      => 'Phường/Xã',
            'address'   => 'Địa chỉ',
        ];
    }
    public static function selectType($default = null, $params = [])
    {
        $data = self::dataType();
        $opts = '';
        foreach ($data as $key => $value) {
            $selected = ($default == $key) ? 'selected' : '';
            $opts .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }
        return '<select id="type" name="type" class="form-control" data-control="select2" style="width: 100%;">
                   ' . (!$default ? '<option value="" selected>--Chọn--</option>' : '') . '
                    ' . $opts . '
                </select>';
    }
    public static function selectData($default = null,$name,$limit = 9999)
    {
        $dataArray = [
            'hotel_id'         => HotelModel::class,
            'category_id'      => HotelCategoryModel::class
        ];

        $data               = [];
        if(isset($dataArray[$name])){
            $data           = $dataArray[$name]::select(['id', 'name'])->where('status', 'active')->orderBy('created_at','desc')
                            ->limit($limit)->get();
        }

        $opts               = '';
        foreach ($data as $item) {
            $selected       = ($default == $item->id) ? 'selected' : '';
            $opts           .= '<option value="' . $item->id . '" ' . $selected . '>' . $item->name . '</option>';
        }

        return '<select id="'.$name.'" name="'.$name.'" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" style="width: 100%;">
                   ' . (!$default ? '<option value="" selected>--Chọn--</option>' : '') . '
                    ' . $opts . '
                </select>';
    }

    public function columnType($params, $field, $val)
    {
        return isset($this->dataType()[$val[$field]]) ? $this->dataType()[$val[$field]] : $val[$field];
    }
    public function columnCategory_id($params, $field, $val)
    {
        return $this->renderColumnWithCheck($val, $field);
    }

    public function columnAddress($params, $field, $val)
    {
        return $this->renderColumnWithCheck($val, $field);
    }

    public function columnCountry_id($params, $field, $val)
    {
        return $this->renderColumnWithCheck($val, $field, 'is_country');
    }

    public function columnCity_id($params, $field, $val)
    {
        return $this->renderColumnWithCheck($val, $field, 'is_city');
    }

    public function columnDistrict_id($params, $field, $val)
    {
        return $this->renderColumnWithCheck($val, $field, 'is_district');
    }

    public function columnWard_id($params, $field, $val)
    {
        return $this->renderColumnWithCheck($val, $field, 'is_ward');
    }
    protected function renderColumnWithCheck($val, $field, $checkKey = null)
    {
        $value      = $val[$field] ?? null;
        $showCheck  = $checkKey ? ($val[$checkKey] ?? false) : ($value !== null && $value !== '');

        if (!$value) return '';

        return  '<div  class="d-flex">' .
                    ($showCheck ? '<i class="fa-solid fa-check mr-2 text-success"></i>' : '') .
                    '<div>' . e($value) . '</div>' .
                '</div>';
    }
}
