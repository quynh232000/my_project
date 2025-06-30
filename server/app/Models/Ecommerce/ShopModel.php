<?php

namespace App\Models\Ecommerce;

use App\Models\Admin\UserModel;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;

class ShopModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        $this->_data        = [
            'listField' => [
                $this->table . '.id'                => 'id',
                $this->table . '.logo'              => 'Logo',
                $this->table . '.name'              => 'Name',
                $this->table . '.email'              => 'Email',
                $this->table . '.phone_number'      => 'Phone',
                $this->table . '.status'            => 'Status',
                'u.full_name AS created_by'         => 'Creator',
                $this->table . '.created_at'        => 'Created At',
                'u2.full_name AS updated_by'        => 'Modifior',
                $this->table . '.updated_at'        => 'Updated At'
            ],
            'fieldSearch' => [
                $this->table . '.name' => 'Tên',
            ],
            'button' => ['show'],
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
                'field' =>  $this->table . '.name',
                'value' => 'name'
            ],
            [
                'field' =>  $this->table . '.email',
                'value' => 'email'
            ],
            [
                'field' =>  $this->table . '.phone_number',
                'value' => 'phone_number'
            ],
            [
                'field' =>  $this->table . '.description',
                'value' => 'description'
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
    public function columnLogo($params, $field, $val)
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
    // start relation
    public function products() {
        return $this->hasMany(ProductModel::class,'shop_id','id');
    }
    public function orders() {
        return $this->hasMany(OrderShopModel::class,'shop_id','id');
    }
    public function user(){
        return $this->belongsTo(UserModel::class,'user_id','id');
    }

}
