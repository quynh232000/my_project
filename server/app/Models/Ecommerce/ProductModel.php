<?php

namespace App\Models\Ecommerce;

use App\Models\Admin\UserModel;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;

class ProductModel  extends AdminModel
{


    protected $table        = null;
    public function __construct($attributes = [])
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        $this->attributes   = $attributes;
        $this->_data        = [
            'listField' => [
                $this->table . '.id'                => 'id',
                $this->table . '.image'             => 'Image',
                $this->table . '.name'              => 'Name',
                $this->table . '.price'             => 'Price',
                $this->table . '.stock'             => 'Stock',
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
    public function creator()
    {
        return   $this->belongsTo(UserModel::class, 'created_by', 'id');
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
            $TABLE_USER = config('constants.table.general.TABLE_USER');
            $query                          = self::select(array_keys($this->_data['listField']))
                ->leftJoin($TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                ->leftJoin($TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by')
                ;

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

                self::whereIn($this->primaryKey, $params['id'])->delete();
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
    public function columnImage($params, $field, $val)
    {

        return '<div class="d-flex justify-content-center px-5">
                    <div class="icon-wrapper cursor-pointer symbol symbol-40px d-flex jusitfy-content-center">
                        <img  src="'.($val[$field] ?? asset('assets/media/auth/505-error.png')).'" alt="">
                    </div>
                </div>';
    }
    public function columnPrice($params, $field, $val){
        return \App\Helpers\Template::formatPrice($val[$field]);
    }
}
