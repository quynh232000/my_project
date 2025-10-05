<?php

namespace App\Models\Cms;

use App\Models\AdminModel;
use App\Models\Api\V1\Cms\PlanModel;
use App\Models\Api\V1\Cms\UserRestaurantRoleModel;
use App\Services\FileService;
use Auth;

class MenuCategoryModel extends AdminModel
{
    protected $guarded = ['id'];
    private $bucket = 's3_hotel';
    public function __construct($attributes = [])
    {
        $this->table = TABLE_CMS_MENU_CATEGORY;
        $this->attributes = $attributes;

        $this->_data = [
            'listField' => [
                $this->table . '.id' => 'id',

                $this->table . '.image' => 'image',
                $this->table . '.name' => 'name',
                'r.name AS  restaurant_id' => 'restaurant_id',

                $this->table . '.status' => 'Trạng thái',
                'u.full_name AS created_by' => 'Người tạo',
                $this->table . '.created_at' => 'Ngày tạo'
            ],
            'fieldSearch' => [
                $this->table . '.name' => 'Tiêu đề',
            ],
            'button' => ['edit', 'delete']
        ];
        parent::__construct();
    }
    public $arrData = [
        'type' => [
            'international' => 'Quốc tế',
            'domestic' => 'Nội địa',
        ]
    ];

    public $crudNotAccepted = [
        'image',
        'thumbnail'
    ];

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
            $date = explode('-', $params['created_at']);
            $start = str_replace(['/'], ['-'], $date[0]);
            $end = str_replace(['/'], ['-'], $date[1]);
            $start = date("Y-m-d H:i:s", strtotime($start));
            $end = date("Y-m-d 23:59:59", strtotime($end));

            $query->whereBetween($this->table . '.created_at', array($start, $end));
        }
        if (isset($params['updated_at']) && !empty($params['updated_at'])) {
            $date = explode('-', $params['updated_at']);
            $start = str_replace(['/'], ['-'], $date[0]);
            $end = str_replace(['/'], ['-'], $date[1]);
            $start = date("Y-m-d H:i:s", strtotime($start));
            $end = date("Y-m-d 23:59:59", strtotime($end));

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
            $this->checkall = true;
            $query = self::select(array_keys($this->_data['listField']))
                ->leftJoin(TABLE_CMS_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                ->leftJoin(TABLE_CMS_RESTAURANT . ' AS r', 'r.id', '=', $this->table . '.restaurant_id');

            $query = self::adminQuery($query, $params);

            $sortBy = isset($params['sort']) && !empty($params['sort']) ? str_replace('-', '_', $params['sort']) : $this->table . '.' . $this->primaryKey;
            $orderBy = isset($params['order']) && !empty($params['order']) ? $params['order'] : 'DESC';

            $this->_data['items'] = $query->orderBy($sortBy, $orderBy)->paginate($params['item-per-page']);

            $this->_data['headTable'] = $this->headTable($this->_data['listField']);
            $this->_data['contentHtml'] = $this->contentHtml($params, $this->_data);
            $this->_data['status'] = true;

            unset($this->_data['headTable']);
        }
        return $this->_data;
    }
    public function getItem($params = null, $options = null)
    {

        $result = null;
        if ($options['task'] == 'get-item-info') {
            $result = self::find($params['id']);
        }
        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
            $params['created_by'] = Auth::user()->id;
            $params['created_at'] = date('Y-m-d H:i:s');


            // insert data
            $item = self::create($this->prepareParams($params));

            if ($params['state'] == 'active') {
                $role = RoleModel::where('name', 'Owner')->first();
                if (!$role) {
                    return $this->error('Chưa có vai trò Owner, vui lòng tạo vai trò Owner trước khi kích hoạt nhà hàng!');
                }

                UserRestaurantRoleModel::updateOrCreate(
                    [
                        'user_id'       => $item->owner_id,
                        'restaurant_id' => $item->id,
                        'role_id'       => $role->id
                    ],
                    [
                        'assigned_by'   => auth('cms')->id(),
                        'assigned_at'   => now(),
                        'status'        => 'active',
                    ]
                );
            }

            $params['insert_id'] = $item->id;

            // upload file
            $hasFile = false;

            if ($params['logo'] ?? false) {
                $params['logo'] = FileService::file_upload($params, $params['logo'], 'logo');
                $hasFile = true;
            }

            // check if has file then update
            if ($hasFile) {
                self::where('id', $params['insert_id'])->update([
                    'logo' => $params['logo'] ?? ''
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Tạo yêu mới cầu thành công!', 'id' => $params['insert_id']]);
        }
        if ($options['task'] == 'edit-item') {

            $params['updated_by'] = Auth::user()->id;
            $params['updated_at'] = date('Y-m-d H:i:s');

            // upload file
            $fileUpload = [];
            $hasFile = false;
            $params['insert_id'] = $params['id'];


            if ($params['logo'] ?? false) {
                $fileUpload['logo'] = FileService::file_upload($params, $params['logo'], 'logo');
            }
            // update data
            $item = self::where('id', $params['id'])->firstOrFail();
            $item->update([...$this->prepareParams($params), ...$fileUpload]);

            if ($params['state'] == 'active') {
                $role = RoleModel::where('name', 'Owner')->first();
                if (!$role) {
                    return $this->error('Chưa có vai trò Owner, vui lòng tạo vai trò Owner trước khi kích hoạt nhà hàng!');
                }

                UserRestaurantRoleModel::updateOrCreate(
                    [
                        'user_id'       => $item->owner_id,
                        'restaurant_id' => $item->id,
                        'role_id'       => $role->id
                    ],
                    [
                        'assigned_by'   => auth()->id(),
                        'assigned_at'   => now(),
                        'status'        => 'active',
                    ]
                );
            }

            return response()->json(['success' => true, 'message' => 'Cập nhật yêu cầu thành công!']);
        }
        if ($options['task'] == 'change-status') {
            $status = ($params['status'] == "active") ? 'inactive' : 'active';
            self::where($this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])
                ->update([
                    'status' => $status,
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
    public static function slbType($default = null, $params = [])
    {
        return '<select id="type" name="type" class="form-control" data-control="select2" style="width: 100%;">
                   ' . (!$default ? '<option value="" selected>--Select--</option>' : '') . '
                    <option value="domestic" ' . ($default == "domestic" ? "selected" : "") . '>Nội địa</option>
                    <option value="international" ' . ($default == "international" ? "selected" : "") . '>Quốc tế</option>
                </select>';
    }
    public function columnType($params, $field, $val)
    {
        return isset($this->arrData['type'][$val[$field]]) ? $this->arrData['type'][$val[$field]] : $val[$field];
    }
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float) str_replace('.', '', $value);
    }
    public function columnImage($params, $field, $val)
    {

        return '<div class="d-flex justify-content-center px-5">
                    <div class="icon-wrapper cursor-pointer symbol symbol-40px d-flex jusitfy-content-center">
                        <img  src="' . ($val[$field] ?? asset('assets/media/auth/505-error.png')) . '" alt="">
                    </div>
                </div>';
    }
    public static function selectUser($default = null, )
    {

        $data = UserModel::select('id', 'full_name', 'email')->orderBy('created_at', 'desc')->get();
        $opts = '';
        foreach ($data as $key => $item) {
            $opts .= '<option title="' . $item['email'] . '" value="' . $item['id'] . '" ' . ($default == $item['id'] ? 'selected' : '') . '>' . $item['full_name'] . '/ ' . $item['email'] . ' </option>';
        }
        return '
            <select class="form-control form-control-sm"  data-control="select2"  name="owner_id">

                ' . $opts . '
            </select>
        ';
    }
    public static function selectType($default = null)
    {

        $data = [
            'cafe' => 'Cafe',
            'restaurant' => 'Nhà hàng',
            'fastfood' => 'Fastfood',
            'bar' => 'Bar',
            'buffet' => 'Buffet',
            'other' => 'Khác',
        ];
        $opts = '';
        foreach ($data as $key => $item) {
            $opts .= '<option  value="' . $key . '" ' . ($default == $key ? 'selected' : '') . '>' . $item . ' </option>';
        }
        return '
            <select class="form-control form-control-sm"  data-control="select2"  name="type">

                ' . $opts . '
            </select>
        ';
    }
    public static function selectState($default = null)
    {

        $data = [
            'new' => 'Mới',
            'active' => 'Đang hoạt động',
            'inactive' => 'Ngừng hoạt động',
            'closed' => 'Đóng cửa',
            'pending' => 'Đang chờ',
        ];
        $opts = '';
        foreach ($data as $key => $item) {
            $opts .= '<option  value="' . $key . '" ' . ($default == $key ? 'selected' : '') . '>' . $item . ' </option>';
        }
        return '
            <select class="form-control form-control-sm"  data-control="select2"  name="state">

                ' . $opts . '
            </select>
        ';
    }
    public static function selectPlan($default = null)
    {

        $data = PlanModel::select('id', 'name')->orderBy('created_at', 'desc')->get();
        $opts = '';
        foreach ($data as $key => $item) {
            $opts .= '<option  value="' . $item['id'] . '" ' . ($default == $item['id'] ? 'selected' : '') . '>' . $item['name'] . ' </option>';
        }
        return '
            <select class="form-control form-control-sm"  data-control="select2"  name="plan_id">

                ' . $opts . '
            </select>
        ';
    }
}
