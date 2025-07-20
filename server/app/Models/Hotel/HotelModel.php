<?php

namespace App\Models\Hotel;

use App\Models\Admin\CountryModel;
use App\Models\AdminModel;
// use App\Models\General\CountryModel;
// use App\Models\General\DistrictModel;
// use App\Models\General\WardModel;
// use App\Services\ElasticService;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use Kalnoy\Nestedset\NodeTrait;

class HotelModel extends AdminModel
{
    // use NodeTrait;
    protected $guarded = ['id'];
    protected $bucket  = 's3_hotel';
    protected $path;
    // protected $elasticService;
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
        'image'
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
        // $this->bucket       = 's3_'.strtolower(basename(__NAMESPACE__));
        // $this->elasticService       = new ElasticService;
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

        if (isset($params['category_id']) && $params['category_id'] !== "all") {
            $query->whereHas('categories', function ($q) use ($params) {
                $q->where(TABLE_HOTEL_HOTEL_CATEGORY . '.id', $params['category_id']);
            });
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

            $query->with('customers:id,full_name,email,phone', 'categories:id,name', 'location');

            $this->_data    = [
                ...$this->_data,
                'listField' => [
                    $this->table . '.id'          => 'id',
                    $this->table . '.name'        => 'Tên khách sạn',
                    'location'                    => 'Địa chỉ',
                    'customers'                   => 'Nhân viên',
                    'acc.name AS accommodation_id' => 'Loại cư trú',
                    $this->table . '.position'    => 'Vị trí',

                    $this->table . '.status'      => 'Trạng thái',
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
    public function uploadImageFile(&$params, $options)
    {
        $image_name            = $options['image_name'] ?? 'image';
        $folderPath            =  $params['controller'] . '/images/' . $options['insert_id'] . '/';
        $image                 = $params[$image_name];
        $imageName             = $params['slug'] . '_' . $image_name . '_' . time() . '.' . $image->extension();
        Storage::disk($this->bucket)->put($folderPath . $imageName, file_get_contents($image));
        $params[$image_name]   = $imageName;
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
                self::uploadImageFile($params, [...$options, 'image_name' => 'image']);
                $fileInsert['image'] = $params['image'];
            }

            // add contract_file
            if (request()->file('contract_file')) {
                self::uploadImageFile($params, [...$options, 'image_name' => 'contract_file']);
                $fileInsert['contract_file'] = $params['contract_file'];
            }
            // add customer
            if (count($params['customer_ids'] ?? []) > 0) {
                $HotelCustomerModel = new HotelCustomerModel();
                $HotelCustomerModel->saveItem($params['customer_ids'], [...$options, 'role' => $params['role'] ?? null]);
            }
            // add category
            if (count($params['category_ids'] ?? []) > 0) {
                $HotelCateIdModel = new HotelCategoryIdModel();
                $HotelCateIdModel->saveItem($params['category_ids'], $options);
            }
            // add location
            $LocationModel = new LocationModel();
            $LocationModel->saveItem($params, $options);

            //add album
            // if(count($params['abumn'] ?? []) > 0){
            //     $HotelAbumnModel       = new HotelAbumnModel();
            //     $options['folderPath'] = $params['controller'] . '/images/' . $options['insert_id'] . '/';
            //     $options['image_name'] = $params['image_name'] ?? [];
            //     $options['slug']       = $params['slug'] ?? '';
            //     $HotelAbumnModel->saveItem($params['abumn'],$options);
            // }
            // //add service and facilities
            // if(count($params['facility'] ?? []) > 0){
            //     $HotelServiceModel     = new HotelServiceModel();
            //     $HotelServiceModel->saveItem($params['facility'],$options);
            // }

            // // add question
            // if(count($params['faqs'] ?? []) > 0){
            //     $HotelFaqsModel        = new HotelFaqsModel();
            //     $HotelFaqsModel->saveItem($params['faqs'],$options);
            // }

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
            // add thumbnail
            if (request()->file('image')) {
                self::uploadImageFile($params, [...$options, 'image_name' => 'image']);
                $fileInsert['image']        = $params['image'];
            }

            // add contract_file
            if (request()->file('contract_file')) {
                self::uploadImageFile($params, [...$options, 'image_name' => 'contract_file']);
                $fileInsert['contract_file'] = $params['contract_file'];
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

            $languages                  = [];
            foreach (($params['language'] ?? []) as $key => $value) {
                $item                   = explode('|', $value);
                $languages[]            = [
                    'id' => $item[0],
                    'name' => $item[1]
                ];
            }
            $params['language']         = json_encode($languages);


            // $HotelAbumnModel       = new HotelAbumnModel();
            // //  delete image in album
            //  $HotelAbumnModel->deleteItem($params['abumn_current'] ?? null,[ ...$options , 'task' => 'delete-item']);
            // //  update type album;
            //  $HotelAbumnModel->saveItem($params['abumn_type'] ?? null,$options);
            //  //  update name image;
            //  $HotelAbumnModel->saveItem($params['image_current_name'] ?? null,['task'=>'update-name-image']);
            // add new album
            // if(count($params['abumn'] ?? []) > 0){
            //     $options['image_name'] = $params['image_name'] ?? [];
            //     $options['slug']       = $params['slug'] ?? '';
            //     $HotelAbumnModel->saveItem($params['abumn'],[...$options,'task' => 'add-item']);
            // }

            // add location
            $LocationModel = new LocationModel();
            $LocationModel->saveItem($params, $options);

            // update category
            $HotelCateIdModel = new HotelCategoryIdModel();
            $HotelCateIdModel->saveItem($params['category_ids'] ?? [], $options);

            // $HotelServiceModel     = new HotelServiceModel();
            // // update service & facilities
            // $HotelServiceModel->saveItem($params['facility'] ?? [],$options);

            // $HotelFaqsModel        = new HotelFaqsModel();
            // // delete faqs
            // $HotelFaqsModel->deleteItem($params['faqs_item'] ?? [],[...$options,'task'=>'delete-item']);
            // // add faqs
            // if(count($params['faqs'] ?? []) > 0){
            //     $HotelFaqsModel    = new HotelFaqsModel();
            //     $HotelFaqsModel->saveItem($params['faqs'],[...$options,'task' => 'add-item']);
            // }
            // // update faqs
            // $HotelFaqsModel->saveItem($params['faqs_current'] ?? [],$options);

            if ($options['lat'] && $options['lng']) {

                $NearbyLocationModel   = new NearbyLocationModel();
                // delete nearby location
                $NearbyLocationModel->deleteItem($params['location_item'] ?? [], [...$options, 'task' => 'delete-items']);
                // update nearby location
                $NearbyLocationModel->saveItem($params['location_current'] ?? [], $options);
                // add nearby location
                if (count($params['location'] ?? []) > 0) {
                    $NearbyLocationModel    = new NearbyLocationModel();
                    $NearbyLocationModel->saveItem($params['location'], [...$options, 'task' => 'add-item']);
                }
            }


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
                $HotelAbumnModel        = new HotelAbumnModel();
                $ServiceModel           = new HotelServiceModel();
                // $RoomTypeModel          = new RoomModel();
                $HotelFaqsModel         = new HotelFaqsModel();
                $NearbyLocationModel    = new NearbyLocationModel();

                $result                     = $result->toArray();
                $params['item']             = $result;
                $result['images']           = $HotelAbumnModel->listItem($params, ['task' => 'list-by-hotel']);
                $result['abumns']           = $HotelAbumnModel->listItem($params, ['task' => 'list-abumn']);
                $result['facilities']       = []; //$ServiceModel->listItem( $params,['task'=>'list-facility-hotel']);
                $result['services']         = []; //$ServiceModel->listItem( $params,['task'=>'list-service-hotel']);
                $result['room_types']       = []; //$RoomTypeModel->listItem( $params,['task'=>'list-by-hotel']);

                $result['faqs']             = []; //$HotelFaqsModel->listItem( $params,['task'=>'list-by-hotel']);
                $result['near_locations']   = $NearbyLocationModel->listItem($params, ['task' => 'list-by-hotel']);

                // get location
                $fields                 = ['country_id', 'city_id', 'district_id', 'ward_id', 'longitude', 'latitude', 'address'];
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
        return '<select id="status" name="status" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
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
            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" id="accommodation_id" name="accommodation_id">
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
        return '<select  onchange="selectTypeImg(this)" class="form-control select2 select2-primary select_type_img "  data-dropdown-css-class="select2-primary">
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
        return  '<select  class="form-control  select2" ' . $multi . ' multiple data-placeholder="--- Chọn ---">
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
            <select class="form-control select2 select2-primary image_name" data-old="' . $dataOld . '" data-dropdown-css-class="select2-primary"  name="' . $name . '">
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
        return '<select id="customer_ids" name="customer_ids[]" class="form-control select2 select2-blue"
                data-dropdown-css-class="select2-blue" style="width: 100%;" multiple data-placeholder="-- Chọn --">
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
            <select class="form-control form-control-' . $size . ' select2 select2-primary image_name"  data-dropdown-css-class="select2-primary"  name="' . $name . '">

                ' . $opts . '
            </select>
        ';
    }
    public function getContractFileAttribute()
    {
        return $this->attributes['contract_file'] ? URL_DATA_IMAGE . 'hotel/hotel/images/' . $this->id . "/" . $this->attributes['contract_file'] : null;
    }
    public function getImageAttribute()
    {
        return $this->attributes['image'] ? URL_DATA_IMAGE . 'hotel/hotel/images/' . $this->id . "/" . $this->attributes['image'] : null;
    }
    public function customers()
    {
        return $this->belongsToMany(CustomerModel::class, TABLE_HOTEL_HOTEL_CUSTOMER, 'hotel_id', 'customer_id')->withPivot('role', 'status', 'id');
    }
    public function columnCustomers($params, $field, $val)
    {
        $hotelNames = array_map(function ($customer) {
            $title = "<div>
                        <div>-Email : " . $customer['email'] . "</div>
                        <div>-Phone : " . $customer['phone'] . "</div>
                    </div>";
            return '<a href="' . route('hotel.customer.edit', ['customer' => $customer['id']]) . '"
                data-toggle="tooltip" data-html="true" data-placement="top" title="' . $title . '"
            >
            ' . $customer['full_name'] . '</a>';
        }, $val['customers']);

        return implode(',<br> ', $hotelNames);
    }

    public static function selectPosition($selecteds = [], $is_muti = true)
    {
        $data           = [
            'trending'      => 'Khách sạn thịnh hành',
            'best_price'    => 'Khách sạn giá tốt',
        ];

        $opts           = '';
        $selecteds      = is_array($selecteds) ? $selecteds : (json_decode($selecteds, true) ?? []);

        foreach ($data as $key => $value) {

            $selected   = (in_array($key, $selecteds ?? []) ?? false) ? 'selected' : '';
            $opts       .= '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
        }

        $muti           = $is_muti ? ' name="position[]" multiple ' : ' name="position"';

        return  '<select  class="form-control select2" ' . $muti . ' data-placeholder="--- Chọn ---">
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
                        <span>" . ($val['location']['city_name'] ?? '') . "</span> ( Index :
                        <div stype='padding:20px'>" . ($val['location']['city_index'] ?? '') . "</div>)
                    </div>
                    <div class='d-flex justify-content-beween'>
                        -
                        <span>Quận/ Huyện:</span>
                        <span>" . ($val['location']['district_name'] ?? '') . "</span> ( Index :
                        <div stype='padding:20px'>" . ($val['location']['district_index'] ?? '') . "</div>)
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
                    ' . ($val['location']['address'] ?? '') . '
                </div></div>';
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
