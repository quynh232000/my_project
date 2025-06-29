<?php

namespace App\Models\Ecommerce;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;

class OrderShopModel  extends AdminModel
{


    protected $table        = null;
    public function __construct($attributes = [])
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        $this->attributes   = $attributes;
        $this->_data        = [
            'listField' => [
                $this->table . '.id'                => 'id',
                's.name AS shop_id'                 => 'Shop',
                'u.email AS user_id'                => 'Buyer',
                'p.name AS payment_method_id'       => 'Payment',
                 $this->table . '.status'           => 'Status',
                 $this->table . '.payment_status'   => 'Payment_status',
                $this->table . '.subtotal'          => 'Subtotal',
                $this->table . '.total'             => 'Total',
                $this->table . '.created_at'        => 'Created At',
                'u2.full_name AS updated_by'        => 'Modifior',
                $this->table . '.updated_at'        => 'Updated At'
            ],
            'fieldSearch' => [
                $this->table . '.name' => 'Tên',
            ],
            'button' => ['edit'],
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
            ]
        ];
        foreach ($dataEqua ?? [] as $item) {
            if (isset($params[$item['value']]) && $params[$item['value']] != "") {
                $query->where($item['field'], '=', $params[$item['value']]);
            }
        }

        // filter by like
        $dataLike = [
            [
                'field' =>  $this->table . '.title',
                'value' => 'title'
            ],
            [
                'field' =>  $this->table . '.from',
                'value' => 'from'
            ],
            [
                'field' =>  $this->table . '.placement',
                'value' => 'placement'
            ],
            [
                'field' =>  $this->table . '.title',
                'value' => 'title'
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
            $TABLE_ORDER = config('constants.table.ecommerce.TABLE_ORDER');
            $TABLE_SHOP = config('constants.table.ecommerce.TABLE_SHOP');
            $TABLE_PAYMENT_METHOD = config('constants.table.ecommerce.TABLE_PAYMENT_METHOD');
            $query                          = self::select(array_keys($this->_data['listField']))
            ->leftJoin($TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by')
            ->leftJoin($TABLE_ORDER . ' AS o', 'o.id', '=', $this->table . '.order_id')
            ->leftJoin($TABLE_USER . ' AS u', 'u.id', '=',  'o.user_id')
            ->leftJoin($TABLE_PAYMENT_METHOD . ' AS p', 'p.id', '=',  'o.payment_method_id')
                ->leftJoin($TABLE_SHOP . ' AS s', 's.id', '=', $this->table . '.shop_id');

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
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') { //thêm mới
            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');
            self::insert($this->prepareParams($params));
            return response()->json(array('success' => true, 'message' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') { //cập nhật
            $params['updated_by']   = Auth::user()->id;
            $params['updated_at']   = date('Y-m-d H:i:s');
            $this->where($this->primaryKey, $params[$this->primaryKey])
                ->update(
                    $this->prepareParams($params)
                );
            return response()->json(array('success' => true, 'message' => 'Cập nhật yêu cầu thành công!'));
        }
        if ($options['task'] == 'change-status') {
            $status = ($params['status'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])
                ->update([
                    'status'    => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
        }
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item-info') {
            $result = self::select($this->table . '.*')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first()->toArray();
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
                        <img  src="' . ($val[$field] ?? asset('assets/media/auth/505-error.png')) . '" alt="">
                    </div>
                </div>';
    }
    public $data = [
        'status'=>[
            'NEW'           => 'warning',
            'PROCESSING'    =>'primary',
            'CANCELLED'     => 'danger'
        ],
        'payment_status' =>[
            'PAID' => 'success',

        ]
    ];
    public function columnStatus($params, $field, $val)
    {

        $html = '<span class="badge badge-'.(isset($this->data['status'][$val[$field]]) ? $this->data['status'][$val[$field]]:'info').'">
                    <span class="legend-indicator bg-'.(isset($this->data['status'][$val[$field]]) ? $this->data['status'][$val[$field]]:'info').'"></span>'.strtolower($val[$field]).'
                </span>';
        return $html;
    }
    public function columnPayment_status($params, $field, $val)
    {

        $html = '<span class="badge badge-'.($val[$field] == 'PAID' ? 'success':'warning').'">
                    <span class="legend-indicator bg-'.(isset($this->data['status'][$val[$field]]) ? $this->data['status'][$val[$field]]:'info').'"></span>'.strtolower($val[$field]).'
                </span>';
        return $html;
    }
    public function columnSubtotal($params, $field, $val)
    {
        return \App\Helpers\Template::formatPrice($val[$field]);
    }
    public function columnTotal($params, $field, $val)
    {
        return \App\Helpers\Template::formatPrice($val[$field]);
    }
}
