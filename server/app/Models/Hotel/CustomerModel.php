<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use App\Services\FileService;

use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Str;

class CustomerModel extends AdminModel
{
    protected $bucket  = 's3_hotel';

    public function __construct()
    {
        $this->table        = TABLE_HMS_CUSTOMER;

        $this->_data        =  [
            'listField'           => [
                $this->table . '.id'            => 'id',
                $this->table . '.full_name'     => 'Họ tên',
                $this->table . '.email'         => 'Email',
                $this->table . '.phone'         => 'Số điện thoại',
                // 'hotels'                        => 'Khách sạn',
                $this->table . '.status'        => 'Trạng thái',
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
        $this->bucket               = config("filesystems.disks.{$this->bucket}.driver") . '_' . config("filesystems.disks.{$this->bucket}.bucket");
    }

    public $crudNotAccepted         = ['password', 'title', 'address', 'hotel_id', 'hotel_customer', 'hotel_customer_ids', 'role', 'hotels_select'];

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
        if (isset($params['full_name']) && $params['full_name'] !== "all") {
            $query->where($this->table . '.full_name', 'LIKE', '%' . $params['full_name'] . '%');
        }
        if (isset($params['email']) && $params['email'] !== "all") {
            $query->where($this->table . '.email', 'LIKE', '%' . $params['email'] . '%');
        }
        if (isset($params['phone']) && $params['phone'] !== "all") {
            $query->where($this->table . '.phone', 'LIKE', '%' . $params['phone'] . '%');
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
        if (!empty($params['hotel'])) {
            $query->whereHas('hotels', function ($q) use ($params) {
                $q->where('name', 'LIKE', '%' . $params['hotel'] . '%');
            });
        }

        return $query;
    }
    public function listItem($params = null, $options = null)
    {
        $this->_data['status'] = false;

        if ($options['task'] == "admin-index") {
            $query = self::select(array_keys($this->_data['listField']))
                ->addSelect(DB::raw("'none' as hotels"))
                ->leftJoin(TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by')
                ->with(['hotels:id,name,slug']);



            $sortBy = isset($params['sort']) && !empty($params['sort']) ? str_replace('-', '_', $params['sort']) : $this->table . '.' . $this->primaryKey;
            $orderBy = isset($params['order']) && !empty($params['order']) ? $params['order'] : 'DESC';
            // dd( $query->toSql());
            // Lấy dữ liệu với phân trang
            $this->_data['listField']    =  [
                $this->table . '.id'            => 'id',
                $this->table . '.full_name'     => 'Họ tên',
                $this->table . '.email'         => 'Email',
                $this->table . '.phone'         => 'Số điện thoại',
                'hotels'                        => 'Khách sạn',
                $this->table . '.status'        => 'Trạng thái',
                'u.full_name AS created_by'     => 'Người tạo',
                $this->table . '.created_at'    => 'Ngày tạo',
                'u2.full_name AS updated_by'    => 'Người sửa',
                $this->table . '.updated_at'    => 'Ngày sửa',
            ];

            $query = self::adminQuery($query, $params);

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
    public function uploadImageFile($params)
    {
        $folderPath            =  $params['controller'] . '/';
        $image                 = $params['image'];
        $imageName             = $params['username'] . '-' . time() . '.' . $image->extension();
        Storage::disk($this->bucket)->put($folderPath . $imageName, file_get_contents($image));
        $params['bucket']      = $this->bucket;
        $this->reSizeImageThumb($params);
        $params['image']       = $imageName;
        unset($params['bucket']);
        return $params;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {

            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');

            $params['insert_id']    = self::insertGetId([
                ...$this->prepareParams($params),
                'password' => Hash::make($params['password'])
            ]);
            if (request()->hasFile('image')) {
                $params['image'] = FileService::file_upload($params, $params['image'], 'image');
                self::where('id', $params['insert_id'])->update(['image' => $params['image']]);
            }

            return response()->json(array('success' => true, 'message' => 'Tạo yêu cầu thành công!', 'id' => $params['insert_id']));
        }
        if ($options['task'] == 'edit-item') {

            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');

            if (request()->hasFile('image')) {
                $params['image']    = FileService::file_upload($params, $params['image'], 'image');
            }

            $data_update                    = $this->prepareParams($params);

            if (!empty($params['password'])) {
                $data_update['password']    = Hash::make($params['password']);
            }
            $HotelCustomerModel             = new HotelCustomerModel();
            // delete customer
            $HotelCustomerModel->deleteItem($params['hotel_customer_ids'] ?? [], [...$options, 'task' => 'delete-item-customer', 'insert_id' => $params['id']]);
            // update customer

            if (count($params['hotel_customer'] ?? []) > 0) {
                $HotelCustomerModel->saveItem($params['hotel_customer'], ['task' => 'edit-item-customer', 'insert_id' => $params['id']]);
            }
            //  add customer hotel
            if (count($params['hotels_select'] ?? []) > 0) {
                $HotelCustomerModel->saveItem($params['hotels_select'], ['task' => 'add-item-customer', 'insert_id' => $params['id'], 'role' => $params['role'] ?? 'manager']);
            }


            $this->where('id', $params['id'])->update($data_update);

            return response()->json(array('success' => true, 'message' => 'Cập nhật yêu cầu thành công!'));
        }
        if ($options['task'] == 'change-status') {

            $status = ($params['status'] == "active") ? "inactive" : "active";

            self::where('id', $params['id'])
                ->update([
                    'status'     => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
        }
    }
    public function getItem($params = null, $options = null)
    {
        $result     = null;
        if ($options['task'] == 'get-item-info') {
            $result                     = self::select($this->table . '.*')->with(['hotels'])->where('id', $params['id'])->first()->toArray();
            $result['hotels_select']    = HotelModel::select('id', 'name')
                ->where('status', 'active')
                ->whereNotIn('id', function ($subQuery) use ($params) {
                    $subQuery->select('hotel_id')->from(TABLE_HOTEL_HOTEL_CUSTOMER)->where('customer_id', $params['id']);
                })
                ->limit(1000)
                ->get()->toArray();
        }
        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            self::whereIn($this->primaryKey, $params['id'])->delete();
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
    public static function selectPartner($default = null, $all = false)
    {

        $data               = PartnerRegisterModel::query();

        if (!$all) {
            $data->where('status', 'success')
                ->whereNotIn('id', function ($subQuery) {
                    $subQuery->select('register_id')->from(TABLE_HMS_CUSTOMER)->whereNotNull('register_id');
                });
        }
        $data               = $data->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $opts               = '';
        foreach ($data as $item) {

            $selected       = $default == $item['id'] ? 'selected' : '';

            $opts           .= '<option
                                    value="' . $item['id'] . '"
                                    ' . $selected . '
                                    data-full_name="' . $item['full_name'] . '"
                                    data-phone="' . $item['phone'] . '"
                                    data-email="' . $item['email'] . '"
                                    data-title="' . $item['title'] . '"
                                    data-address="' . $item['address'] . '"
                                    data-username="' . explode('@', $item['email'])[0] . '"
                                >
                                    ' . $item['email'] . '
                                </option>';
        }
        return '
            <select ' . ($all ? 'readonly disabled' : '') . ' class="form-control  image_name" data-control="select2" id="register_id"  name="register_id">
                <option value="">-- Chọn --</option>
                ' . $opts . '
            </select>
        ';
    }
    public static function selectRole($default = null)
    {

        $data               = [
            // 'admin'     => 'Quản trị viên',
            'manager'   => 'Quản lý',
            'staff'     => 'Nhân viên',
            // 'partner'   => 'Đối tác',
            // 'customer'  => 'Khách hàng'
        ];

        $opts               = '';
        foreach ($data as $key => $item) {
            $selected       = $default == $key ? 'selected' : '';
            $opts           .= '<option
                                    value="' . $key . '"
                                    ' . $selected . '
                                >
                                    ' . $item . '
                                </option>';
        }
        return '
            <select  class="form-control select2 select2-primary " data-dropdown-css-class="select2-primary" id="role"  name="role">
                ' . $opts . '
            </select>
        ';
    }
    public function hotel()
    {
        return $this->hasOne(HotelModel::class, 'customer_id', 'id');
    }
    public function hotels()
    {
        return $this->belongsToMany(HotelModel::class, TABLE_HOTEL_HOTEL_CUSTOMER, 'customer_id', 'hotel_id')->withPivot('role', 'status', 'id');
    }

    public function columnHotels($params, $field, $val)
    {
        $params['hotels']    = $val['hotels'] ?? [];
        $params['id']           = $val['id'] ?? '';
        return view("{$params['prefix']}.{$params['controller']}.components.modal-hotel", ['params' => $params]);


        // $hotelNames = array_map(function ($hotel) {
        //     return '<a href="'.route('hotel.hotel.edit',['hotel'=>$hotel['id']]).'" title="'.$hotel['id'].'">'.$hotel['name'].'</a>';
        // }, $val['hotels']);

        // return implode(',<br> ', $hotelNames);
    }
}
