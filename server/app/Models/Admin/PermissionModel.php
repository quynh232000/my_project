<?php

namespace App\Models\Admin;

use App\Models\AdminModel;
class PermissionModel  extends AdminModel
{
    protected $table        = null;
    protected $guarded        = [];
    public function __construct()
    {
        $this->table        = config('constants.table.general.TABLE_PERMISSION');
        $this->_data        = [
            'listField' => [
                $this->table . '.id'                => 'id',
                $this->table . '.resource_type'     => 'resource_type',
                $this->table . '.name'              => 'name',
                $this->table . '.uri'               => 'uri',
                $this->table . '.route_name'        => 'route_name',
                $this->table . '.method'            => 'method',
                $this->table . '.status'            => 'status',
                $this->table . '.created_at'        => 'Created At',
                $this->table . '.updated_at'        => 'Updated At'
            ],
            'fieldSearch' => [
                $this->table . '.name' => 'Tên',
            ],
            'button' => ['edit','delete'],
        ];
        parent::__construct();
    }
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
                'field' =>  $this->table . '.resource_type',
                'value' => 'resource_type'
            ],
            [
                'field' =>  $this->table . '.name',
                'value' => 'name'
            ],
            [
                'field' =>  $this->table . '.uri',
                'value' => 'uri'
            ],
            [
                'field' =>  $this->table . '.route_name',
                'value' => 'route_name'
            ],
             [
                'field' =>  $this->table . '.method',
                'value' => 'method'
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
            $query                          = self::select(array_keys($this->_data['listField']));
                // ->leftJoin($TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                // ->leftJoin($TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by');

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
            $params['created_by']   = auth()->user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');

            self::insert($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') { //cập nhật
            $params['updated_by']   = auth()->user()->id;
            $params['updated_at']   = date('Y-m-d H:i:s');

            $params['status'] = $params['status'] ?? 'inactive';



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
                    'updated_by'    => auth()->user()->id
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
    public function columnThumbnail($params, $field, $val)
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
    public function columnMethod($params, $field, $val)
    {
        $data = [
            'GET|HEAD'  => 'primary',
            'POST'      => 'success',
            'PUT'       => 'warning',
            'DELETE'    => 'danger',
            'PUT|PATCH' => 'warning',
        ];
        return '<span class="badge badge-'.(isset($data[$val[$field]]) ? $data[$val[$field]]: 'warning').'">
                    <span class="legend-indicator bg-'.(isset($data[$val[$field]]) ? $data[$val[$field]]: 'warning').'"></span>'.$val[$field].'
                </span>';
    }
}
