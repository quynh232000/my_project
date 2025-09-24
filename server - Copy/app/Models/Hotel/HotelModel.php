<?php

namespace App\Models\Hotel;

use App\Models\Admin\CountryModel;
use App\Models\AdminModel;
// use App\Models\General\CountryModel;
// use App\Models\General\DistrictModel;
// use App\Models\General\WardModel;
// use App\Services\ElasticService;
use App\Services\FileService;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use Kalnoy\Nestedset\NodeTrait;

class HotelModel extends AdminModel
{
    protected $guarded = ['id'];
    protected $bucket  = 's3_hotel';
    protected $path;
    public $crudNotAccepted = [
        'abumn',
        'facility',
        'faqs',
        'location_type',
        'location',
        'image_name',
        'image_old',
        'customer_ids',
        'hotel_customer',
        'hotel_customer_ids',
        'role',
        'country_id',
        'city_id',
        'ward_id',
        'district_id',
        'longitude',
        'latitude',
        'address',
        'index',
        'category_ids',
    ];
    public function __construct($attributes = [])
    {
        $this->table = TABLE_HOTEL_HOTEL;

        $this->attributes = $attributes;
        $this->_data = [
            'listField' => [
                $this->table . '.id'          => 'id',
                $this->table . '.name'        => 'Tên',
                'acc.name AS accommodation_id' => 'Loại cư trú',
                $this->table . '.status'      => 'Trạng thái',
                $this->table . '.position'      => 'Vị trí',
                'u.full_name AS created_by'   => 'Người tạo',
                $this->table . '.created_at'  => 'Ngày tạo',
                'u2.full_name AS updated_by'  => 'Người sửa',
                $this->table . '.updated_at'  => 'Ngày sửa',
            ],
            'fieldSearch'   =>  [
                $this->table . '.name' => 'Tên',
            ],
            'button'        =>  ['edit', 'delete',],
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
        if (isset($params['full_name_update']) && $params['full_name_update'] !== "all") {
            $query->where('u2.full_name', 'LIKE', '%' . $params['full_name_update'] . '%');
        }
        if (isset($params['name']) && $params['name'] !== "all") {
            $query->where($this->table . '.name', 'LIKE', '%' . $params['name'] . '%');
        }
        if (isset($params['created']) && !empty($params['created'])) {
            $date  = explode('-', $params['created']);
            $start = str_replace(['/'], ['-'], $date[0]);
            $end   = str_replace(['/'], ['-'], $date[1]);
            $start = date("Y-m-d H:i:s", strtotime($start));
            $end   = date("Y-m-d 23:59:59", strtotime($end));

            $query->whereBetween($this . '.created', array($start, $end));
        }
        if (isset($params['status']) && $params['status'] != "") {
            $query->where($this->table . '.status', '=', $params['status']);
        }
        if (isset($params['accommodation_id']) && $params['accommodation_id'] != "") {
            $query->where($this->table . '.accommodation_id', '=', $params['accommodation_id']);
        }
        if (isset($params['country_id']) && $params['country_id'] != "") {
            $query->where('lo.country_id', '=', $params['country_id']);
        }
        if (isset($params['city_id']) && $params['city_id'] != "") {
            $query->where('lo.city_id', '=', $params['city_id']);
        }
        if (isset($params['district_id']) && $params['district_id'] != "") {
            $query->where('lo.district_id', '=', $params['district_id']);
        }
        if (isset($params['ward_id']) && $params['ward_id'] != "") {
            $query->where('lo.ward_id', '=', $params['ward_id']);
        }
        if (isset($params['address']) && $params['address'] !== "all") {
            $query->where('address', 'LIKE', '%' . $params['address'] . '%');
        }



        if (isset($params['customer']) && !empty($params['customer'])) {
            $query->whereHas('customers', function ($q) use ($params) {
                $q->where(function ($sub) use ($params) {
                    $sub->where('full_name', 'LIKE', '%' . $params['customer'] . '%')
                        ->orWhere('phone', 'LIKE', '%' . $params['customer'] . '%')
                        ->orWhere('email', 'LIKE', '%' . $params['customer'] . '%');
                });
            });
        }
        return $query;
    }
    public function listItem($params = null, $options = null)
    {
        $this->_data['status']  = false;
        if ($options['task']    == "admin-index") {
            $this->checkall     = true;
            $query              = self::select(array_keys($this->_data['listField']))
                ->leftJoin(TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by')
                ->leftJoin(TABLE_HOTEL_LOCATION . ' AS lo', 'lo.hotel_id', '=', $this->table . '.id')
                ->leftJoin(TABLE_HOTEL_ATTRIBUTE . ' AS acc', 'acc.id', '=', $this->table . '.accommodation_id');

            $query->with('customers:id,full_name,email,phone', 'location');

            $this->_data    = [
                ...$this->_data,
                'listField' => [
                    $this->table . '.id'          => 'id',
                    $this->table . '.name'        => 'Tên khách sạn',
                    'location'                    => 'Địa chỉ',
                    'acc.name AS accommodation_id' => 'Loại cư trú',
                    $this->table . '.position'    => 'Vị trí',
                    $this->table . '.status'      => 'Trạng thái',
                    'customers'                   => 'Nhân viên',
                    'u.full_name AS created_by'   => 'Người tạo',
                    $this->table . '.created_at'  => 'Ngày tạo',
                    'u2.full_name AS updated_by'  => 'Người sửa',
                    $this->table . '.updated_at'  => 'Ngày sửa',
                ]
            ];
            $query      = self::adminQuery($query, $params);
            $sortBy     = isset($params['sort']) && !empty($params['sort']) ? str_replace('-', '_', $params['sort']) : $this->table . '.' . $this->primaryKey;
            $orderBy    = isset($params['order']) && !empty($params['order']) ? $params['order'] : 'DESC';
            $this->_data['items']         = $query->orderBy($sortBy, $orderBy)->paginate($params['item-per-page']);

            $this->_data['total']         = $this->_data['items']->total();
            $this->_data['headTable']     = $this->headTable($this->_data['listField']);
            $this->_data['contentHtml']   = $this->contentHtml($params, $this->_data);
            $this->_data['status']        = true;

            unset($this->_data['headTable']);
        }
        if ($options['task'] == "list-hotel-select") {
            $this->_data['list']          = self::select(['id', 'name', 'latitude', 'longitude'])->orderBy('created_at')->get()->toArray();
        }
        if ($options['task'] == "get-all") {
            $this->_data['hotel']         = self::select('id', 'name')->get();
        }
        return $this->_data;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');
            if ($params['position'] ?? false) {
                $params['position'] = json_encode($params['position']);
            }
            // add languages
            $languages                  = [];
            foreach (($params['language'] ?? []) as $key => $value) {
                $item                   = explode('|', $value);
                $languages[]            = [
                    'id' => $item[0],
                    'name' => $item[1]
                ];
            }
            $params['language']         = json_encode($languages);

            $options['insert_id']   = self::create($this->prepareParams($params))->id;

            $fileInsert             = [];
            // add thumbnail
            if (request()->file('image')) {
                $params['image'] = FileService::file_upload($params, $params['image'], 'image');
            }

            // add contract_file
            if (request()->file('contract_file')) {
                $params['contract_file'] = FileService::file_upload($params, $params['contract_file'], 'contract_file');
            }
            // add customer
            if (count($params['customer_ids'] ?? []) > 0) {
                $HotelCustomerModel = new HotelCustomerModel();
                $HotelCustomerModel->saveItem($params['customer_ids'], [...$options, 'role' => $params['role'] ?? null]);
            }

            // add location
            $LocationModel = new LocationModel();
            $LocationModel->saveItem($params, $options);



            // add nearby location
            if (count($params['location'] ?? []) > 0 && ($params['latitude'] && $params['longitude'])) {
                $NearbyLocationModel    = new NearbyLocationModel();
                $options['lat']         = $params['latitude'];
                $options['lng']         = $params['longitude'];
                $NearbyLocationModel->saveItem($params['location'], $options);
            }

            if (count($fileInsert) > 0) {
                self::where('id', $options['insert_id'])->update($fileInsert);
            }

            return response()->json(array('success' => true, 'message' => 'Tạo yêu cầu thành công!', 'id' => $options['insert_id']));
        }

        if ($options['task'] == 'edit-item') {
            $params['updated_by']  = Auth::user()->id;
            $params['updated_at']  = date('Y-m-d H:i:s');
            $options['insert_id']  = $params['id'];
            $options['folderPath'] = $params['controller'] . '/images/' . $options['insert_id'] . '/';
            $options['lat']        = $params['latitude'] ?? null;
            $options['lng']        = $params['longitude'] ?? null;

            $fileInsert            = [];
            if ($params['position'] ?? false) {
                $params['position'] = json_encode($params['position']);
            }
            if (request()->file('image')) {
                $params['image'] = FileService::file_upload($params, $params['image'], 'image');
            }

            // add contract_file
            if (request()->file('contract_file')) {
                $params['contract_file'] = FileService::file_upload($params, $params['contract_file'], 'contract_file');
            }

            $HotelCustomerModel = new HotelCustomerModel();
            // delete customer
            $HotelCustomerModel->deleteItem($params['hotel_customer_ids'] ?? [], [...$options, 'task' => 'delete-item']);
            // update customer
            if (count($params['hotel_customer'] ?? []) > 0) {
                $HotelCustomerModel->saveItem($params['hotel_customer'], $options);
            }
            // add customer
            if (count($params['customer_ids'] ?? []) > 0) {
                $HotelCustomerModel->saveItem($params['customer_ids'], [...$options, 'task' => 'add-item']);
            }


            // add location
            $LocationModel = new LocationModel();
            $LocationModel->saveItem($params, $options);

            if ($options['lat'] && $options['lng']) {

                $NearbyLocationModel   = new NearbyLocationModel();
                // delete nearby location
                $NearbyLocationModel->deleteItem($params['location_item'] ?? [], [...$options, 'task' => 'delete-items']);
                // update nearby location
                $NearbyLocationModel->saveItem($params['location_current'] ?? [], $options);
                // add nearby location
                if (count($params['location'] ?? []) > 0) {
                    // dd($params['location']);
                    $NearbyLocationModel    = new NearbyLocationModel();
                    $NearbyLocationModel->saveItem($params['location'], [...$options, 'task' => 'add-item']);
                }
            }

            // dd([...$this->prepareParams($params), ...$fileInsert]);
            self::findOrFail($params['id'])->update([...$this->prepareParams($params), ...$fileInsert]);
            return response()->json(array('success' => true, 'message' => 'Cập nhật yêu cầu thành công!'));
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

    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item-info') {
            $result = self::select($this->table . '.*')
                ->with('customers', 'location', 'categories:id,name')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();

            if ($result != null) {
                $NearbyLocationModel    = new NearbyLocationModel();
                $result                     = $result->toArray();
                $params['item']             = $result;
                // dd($params['item']);
                $result['near_locations']   = $NearbyLocationModel->listItem($params, ['task' => 'list-by-hotel']);
                // get location
                $fields                 = ['country_id', 'province_id', 'ward_id', 'longitude', 'latitude', 'address'];
                foreach ($fields as $field) {
                    $result[$field]     = $result['location'][$field] ?? null;
                }
                // $result['location']     = [];


            }
        }
        if ($options['task'] == 'get-info') {
            $ServiceModel           = new ServiceModel();

            $result['country']      = CountryModel::select('id', 'name')->get()->toArray();
            $result['services']     = $ServiceModel->getItem($params, ['task' => 'get-hotel-service']);
        }

        if ($options['task'] == "get-slug-by-id") {
            $result  = self::select('id', 'slug')->find($params);
        }
        if ($options['task'] == 'get-date-based-price') {
            // $result = self::select($this->table . '.*')->with(['roomTypes.priceTypes.dateBasedPricings'])
            //     ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();
            $result = self::select($this->table . '.id')
                ->with(['roomTypes.priceTypes.priceRules', 'roomTypes.priceTypes.dateBasedPricings.capacityPrices'])
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])
                ->first();

            if ($result) {
                foreach ($result->roomTypes as $roomType) {
                    foreach ($roomType->priceTypes as $priceType) {
                        $priceType->date_based_prices = $priceType->dateBasedPricings->filter(function ($pricing) use ($roomType, $priceType) {
                            return $pricing->room_type_id == $roomType->id && $pricing->price_type_id == $priceType->id;
                        })->values()->toArray();

                        unset($priceType->dateBasedPricings);
                        $priceType->price_rules = $priceType->priceRules->filter(function ($rule) use ($roomType, $priceType) {
                            return $rule->room_type_id == $roomType->id && $rule->price_type_id == $priceType->id;
                        })->values()->toArray();
                        unset($priceType->priceRules);
                    }
                }
            }
        }
        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {
            } elseif (is_array($params['id'])) {
                self::whereIn($this->primaryKey, $params['id'])->whereNotIn('status', ['finish', 'pending-print', 'signed'])->delete();
            }
        }
    }
    public static function slbStatus($default = null, $params = [])
    {
        return '<select id="status" name="status" class="form-control" data-control="select2" style="width: 100%;">
                   ' . (!$default ? '<option value="" selected>Chọn trạng thái</option>' : '') . '
                    <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
                    <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
                </select>';
    }
    public static function selectAccommodation($default = null)
    {
        $parent     = AttributeModel::select('id')->where('slug', 'accommodation_type')->first();
        $data       = AttributeModel::select('id', 'name')
            ->where('parent_id', $parent->id)
            ->get()
            ->toArray();
        $opts       = '';
        foreach ($data as $item) {
            $opts .= '<option value="' . $item['id'] . '" ' . ($default == $item['id'] ? 'selected' : '') . '>' . $item['name'] . '</option>';
        }
        return '
            <select class="form-control " data-control="select2" id="accommodation_id" name="accommodation_id">
                <option value="">-- Chọn --</option>
                ' . $opts . '
            </select>
        ';
    }
    public function getListService()
    {
        $data = null;
        $data['services']        = ServiceModel::where(['status' => 'active', 'parent_id' => null, 'type' => 'hotel'])->get()->toArray();
        $data['facilities']      = ServiceModel::where(['status' => 'active'])->whereNotNull('parent_id')->get()->toArray();
        $data['facilitiesHotel'] = ServiceModel::where(['status' => 'active', 'type' => 'hotel'])->whereNotNull('parent_id')->get()->toArray();
        return $data;
    }
    public function roomTypes()
    {
        return $this->hasMany(RoomTypeModel::class, 'hotel_id');
    }
    public static function slbAlbumType($selected = 'other', $isThumb = false)
    {
        if ($isThumb) {
            $dataType   = [
                'thumbnail'     => 'Ảnh bìa',
            ];
            $selected   = 'thumbnail';
        } else {
            $dataType   = [
                'other'         => 'Khác',
                'thumbnail'     => 'Ảnh bìa',
                'room_type'     => 'Loại phòng',
                // 'service'       => 'Dịch vụ/ Tiện ích',
            ];
        }
        $html       = '';
        foreach ($dataType as $key => $value) {
            $html .= '<option ' . ($key == $selected ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
        }
        return '<select  onchange="selectTypeImg(this)" class="form-control  select_type_img "  data-control="select2">
                    ' . $html . '
                </select>';
    }
    public static function selectLanguage($selecteds = [], $is_multi = true)
    {
        $data           = CountryModel::select('id', 'name')
            ->where(['status' => 'active'])
            ->get()
            ->toArray();

        $opts           = '';
        $selecteds      = is_array($selecteds) ? $selecteds : (json_decode($selecteds, true) ?? []);
        $ids            = is_array($selecteds ?? []) ? array_column($selecteds, 'id') : [];
        foreach ($data as $key => $item) {

            $selected   =  in_array($item['id'], $ids) ? 'selected' : '';
            $opts       .= '<option ' . $selected . ' value="' . ($item['id'] . '|' . $item['name']) . '">' . $item['name'] . '</option>';
        }
        $multi =  'name="language[]"';
        return  '<select  class="form-control  " ' . $multi . ' data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                    <option value="">--Chọn--</option>
                    ' . $opts . '
                </select>';
    }

    public static function selectImageLabel($default = null, $name = 'image_name[other][]', $dataOld = null)
    {
        $parent     = AttributeModel::select('id')->where('slug', 'image_type')->first();
        $data       = AttributeModel::select('id', 'name')
            ->where('parent_id', $parent->id)
            ->get()
            ->toArray();
        $opts       = '';
        foreach ($data as $item) {
            $opts   .= '<option value="' . $item['id'] . '" ' . ($default == $item['id'] ? 'selected' : '') . '>' . $item['name'] . '</option>';
        }
        return '
            <select class="form-control  image_name" data-old="' . $dataOld . '" data-control="select2"  name="' . $name . '">
                <option value="">-- Chọn --</option>
                ' . $opts . '
            </select>
        ';
    }
    public static function selectCustomer($selected = [], $hotel_id = null)
    {

        if ($hotel_id) {
            $data = CustomerModel::whereNotIn('id', function ($q) use ($hotel_id) {
                $q->select('customer_id')
                    ->from(TABLE_HOTEL_HOTEL_CUSTOMER)
                    ->when($hotel_id, function ($query) use ($hotel_id) {
                        $query->where('hotel_id', $hotel_id);
                    })
                    ->groupBy('customer_id');
            })->get();
        } else {
            $data = CustomerModel::get();
        }

        $html       = '';
        foreach ($data as $key => $value) {
            $html .= '<option ' . ($key == $selected ? 'selected' : '') . ' value="' . $value->id . '">' . $value->full_name . ' (' . $value->email . ')</option>';
        }
        return '<select id="customer_ids" name="customer_ids[]" class="form-control"
                data-control="select2" style="width: 100%;" data-allow-clear="true" multiple="multiple" data-placeholder="-- Chọn --">
                    ' . $html . '
                </select>';
    }
    public static function selectRole($default = null, $name = 'role', $size = 'sm')
    {

        $data       = [
            'manager' => 'Quản lý',
            'staff'   => 'Nhân viên'
        ];
        $opts       = '';
        foreach ($data as $key => $item) {
            $opts   .= '<option value="' . $key . '" ' . ($default == $key ? 'selected' : '') . '>' . $item . '</option>';
        }
        return '
            <select class="form-control form-control-' . $size . '  image_name"  data-control="select2"  name="' . $name . '">

                ' . $opts . '
            </select>
        ';
    }

    public function customers()
    {
        return $this->belongsToMany(CustomerModel::class, TABLE_HOTEL_HOTEL_CUSTOMER, 'hotel_id', 'customer_id')->withPivot('role', 'status', 'id');
    }


    public static function selectPosition($selecteds = [], $is_muti = true)
    {
        $data           = [
            'trending'      => 'Khách sạn Sale',
            'best_price'    => 'Khách sạn giá tốt',
        ];

        $opts           = '';
        $selecteds      = is_array($selecteds) ? $selecteds : (json_decode($selecteds, true) ?? []);

        foreach ($data as $key => $value) {

            $selected   = (in_array($key, $selecteds ?? []) ?? false) ? 'selected' : '';
            $opts       .= '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
        }

        $muti           = $is_muti ? ' name="position[]" multiple ' : ' name="position"';

        return  '<select  class="form-control " ' . $muti . ' data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                    ' . ($is_muti ? '' : '<option value="">--Chọn--</option>') . '
                    ' . $opts . '
                </select>';
    }
    public function columnLocation($params, $field, $val)
    {
        $title = "<div>
                    <div class='d-flex justify-content-beween'>
                        -
                        <span>Quốc gia:</span>
                        <span>" . ($val['location']['country_name'] ?? '') . "</span> ( Index :
                        <div stype='padding:20px'>" . ($val['location']['country_index'] ?? '') . "</div>)
                    </div>
                    <div class='d-flex justify-content-beween'>
                        -
                        <span>Tỉnh/ Thành phố:</span>
                        <span>" . ($val['location']['province_name'] ?? '') . "</span> ( Index :
                        <div stype='padding:20px'>" . ($val['location']['province_index'] ?? '') . "</div>)
                    </div>

                    <div class='d-flex justify-content-beween'>
                        -
                        <span>Phường/ Xã:</span>
                        <span>" . ($val['location']['ward_name'] ?? '') . "</span> ( Index :
                        <div stype='padding:20px'>" . ($val['location']['ward_index'] ?? '') . "</div>)
                    </div>
                    <div class='d-flex justify-content-beween'>
                        -
                        <span>Địa chỉ:</span>
                        <span>" . ($val['location']['address'] ?? '') . "</span>
                    </div>
                </div>";

        return '<div class="address"><div  data-toggle="tooltip" data-html="true" data-placement="top" title="' . $title . '">
                    ' . "{$val['location']['ward_name']}, {$val['location']['province_name']}, {$val['location']['country_name']}" . '
                </div></div>';
    }
    public function columnCustomers($params, $field, $val)
    {
        $params['customers']    = $val['customers'] ?? [];
        $params['id']           = $val['id'] ?? '';
        $params['name']         = $val['name'] ?? '';
        return view("{$params['prefix']}.{$params['controller']}.components.modal-customer", ['params' => $params]);
    }
    public function columnPosition($params, $field, $val)
    {
        $data               = [
            'trending'      => 'Thịnh hành',
            'best_price'    => 'Giá tốt',
        ];

        $values             = $val[$field] ?? [];
        $values             = is_array($values) ? $values : (json_decode($values, true) ?? []);

        $valueData          = [];
        foreach ($values as $key => $value) {
            $valueData[]    = '<div class="badge badge-info text-white">' . ($data[$value] ?? $value) . '</div>';
        }
        return implode(' ', $valueData);
    }

    public function columnCategories($params, $field, $val)
    {
        $categoryNames = array_map(function ($category) {
            return $category['name'];
        }, $val['categories']);
        return implode(', <br/>', $categoryNames);
    }
    public function location()
    {
        return $this->hasOne(LocationModel::class, 'hotel_id', 'id');
    }
    public function categories()
    {
        return $this->belongsToMany(HotelCategoryModel::class, TABLE_HOTEL_HOTEL_CATEGORY_ID, 'hotel_id', 'category_id');
    }
}
