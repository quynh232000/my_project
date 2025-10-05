<?php

namespace App\Models\Admin;

use App\Models\AdminModel;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Str;

class ProvinceModel  extends AdminModel
{
    protected $table        = null;
    public function __construct($attributes = [])
    {
        $this->table        = config('constants.table.general.' . self::getTable());
        $this->attributes   = $attributes;
        $this->_data        = [
            'listField' => [
                $this->table . '.id'                => 'id',
                $this->table . '.name'              => 'name',
                $this->table . '.slug'              => 'slug',
                $this->table . '.code'              => 'code',
                $this->table . '.place_type'        => 'place_type',
                $this->table . '.country'           => 'country',
                $this->table . '.status'            => 'Status',
                'u.full_name AS created_by'         => 'Creator',
                $this->table . '.created_at'        => 'Created At',
                'u2.full_name AS updated_by'        => 'Modifior',
                $this->table . '.updated_at'        => 'Updated At'
            ],
            'fieldSearch' => [
                $this->table . '.name' => 'Tên',
            ],
            'button' => ['edit', 'delete'],
        ];
        parent::__construct();
    }
    protected $guarded       = [];
    public function adminQuery(&$query, $params)
    {
        if ($params['created_at'] ?? false) {
            $query->whereDate($this->table . '.created_at', $params['created_at']);
        }
        if ($params['updated_at'] ?? false) {
            $query->whereDate($this->table . '.updated_at', $params['updated_at']);
        }
        // filter by equa
        $dataEqua = [
            [
                'field' => $this->table . '.status',
                'value' => 'status'
            ],

        ];
        foreach ($dataEqua ?? [] as $item) {
            if (isset($params[$item['value']]) && $params[$item['value']] != "") {
                $query->where($item['field'], '=', $params[$item['value']]);
            }
        }

        // filter by like
        $dataLike = [
            [
                'field' =>  $this->table . '.name',
                'value' => 'name'
            ],
            [
                'field' =>  $this->table . '.slug',
                'value' => 'slug'
            ],
            [
                'field' =>  $this->table . '.short_name',
                'value' => 'short_name'
            ],
            [
                'field' =>  $this->table . '.code',
                'value' => 'code'
            ],
            [
                'field' =>  $this->table . '.place_type',
                'value' => 'place_type'
            ],
            [
                'field' =>  $this->table . '.country',
                'value' => 'country'
            ],
            [
                'field' =>  $this->table . '.created_by',
                'value' => 'created_by'
            ],
            [
                'field' => 'u.full_name',
                'value' => 'full_name'
            ],
        ];
        foreach ($dataLike ?? [] as $item) {
            if (isset($params[$item['value']]) && $params[$item['value']] != "") {
                $query->where($item['field'], 'LIKE', '%' . $params[$item['value']] . '%');
            }
        }
        return $query;
    }
    public function listItem($params = null, $options = null)
    {

        $this->_data['status'] = false;

        if ($options['task'] == "admin-index") {
            $this->checkall   = true;
            $TABLE_USER = config('constants.table.general.TABLE_USER');
            $query                          = self::select(array_keys($this->_data['listField']))
                ->leftJoin($TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                ->leftJoin($TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by');

            $query                          = self::adminQuery($query, $params);

            $sortBy                         = isset($params['sort']) && !empty($params['sort']) ? str_replace('-', '_', $params['sort']) : $this->table . '.' . $this->primaryKey;
            $orderBy                        = isset($params['order']) && !empty($params['order']) ? $params['order'] : 'DESC';

            $this->_data['items']           =  $query->orderBy($sortBy, $orderBy)->paginate($params['item-per-page']);

            $this->_data['headTable']       = $this->headTable($this->_data['listField']);
            $this->_data['contentHtml']     = $this->contentHtml($params, $this->_data);
            $this->_data['status']          = true;

            unset($this->_data['headTable']);
        }
        if ($options['task'] == 'list-items') {

            $this->_data      = self::select('id', 'name')
                ->where('country_id', $params['country_id'])
                ->where('status', 'active')
                ->orderBy('name', 'asc')->get()->toArray();
        }
        return $this->_data;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') { //thêm mới
            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');
            $params['slug']         = Str::slug($params['name']);
            if ($params['icon'] ?? false) {
                $FileService = new FileService();
                $params['icon_url'] = $FileService->uploadFile($params['icon'], 'ecommerce.category', auth()->id())['url'] ?? '';
                unset($params['icon']);
            } else {
                $params['icon_url'] = $params['icon_link'] ?? '';
            }
            unset($params['icon_link']);

            self::insert($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') { //cập nhật
            $params['updated_by']   = Auth::user()->id;
            $params['updated_at']   = date('Y-m-d H:i:s');
            $params['slug']         = Str::slug($params['name']);
            if ($params['icon'] ?? false) {
                $FileService = new FileService();
                $params['icon_url'] = $FileService->uploadFile($params['icon'], 'ecommerce.category', auth()->id())['url'] ?? '';
                unset($params['icon']);
            } else {
                $params['icon_url'] = $params['icon_link'] ?? '';
            }
            unset($params['icon_link']);


            $this->where($this->primaryKey, $params[$this->primaryKey])
                ->update(
                    $this->prepareParams($params)
                );
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
        return ['status' => 'success', 'message' => 'Require created successfully!'];
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item-info') {
            $result = self::select($this->table . '.*')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();
        }
        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {
            } else {
                self::whereIn('id', $params['id'])->delete();
            }
        }
    }
    public static function slbStatus($default = null, $params = [])
    {
        return '<select class="form-select mb-2" id="status" data-control="select2" name="status"
                        data-placeholder="Select an option" data-allow-clear="true">
                   ' . (!$default ? '<option value="" selected>Chọn trạng thái</option>' : '') . '
                    <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
                    <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
                </select>';
    }
    public function columnIcon_url($params, $field, $val)
    {
        return '<div class="d-flex justify-content-center px-5">
                    <div class="icon-wrapper cursor-pointer symbol symbol-40px d-flex jusitfy-content-center">
                        <img  src="' . ($val[$field] ? $val[$field] : asset('assets/media/auth/505-error.png')) . '" alt="">
                    </div>
                </div>';
    }
    public function columnPrice($params, $field, $val)
    {
        return \App\Helpers\Template::formatPrice($val[$field]);
    }
}
