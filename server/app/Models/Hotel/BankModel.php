<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
class BankModel extends AdminModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_BANK;

        $this->_data        =  [
            'listField'           => [
                $this->table . '.id'            => 'id',
                $this->table . '.name'          => 'Tên ',
                $this->table . '.short_name'    => 'Tên viết tắt',
                $this->table . '.code'          => 'Code',
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
    }
    public $crudNotAccepted     = ['branch','branch_current'];
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
        if (isset($params['short_name']) && $params['short_name'] !== "all") {
            $query->where($this->table . '.short_name', 'LIKE', '%' . $params['short_name'] . '%');
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
        if (isset($params['code']) && $params['code'] != "") {
            $query->where($this->table . '.code', '=', $params['code']);
        }

        return $query;
    }
    public function listItem($params = null, $options = null)
    {

        $this->_data['status'] = false;

        if ($options['task'] == "admin-index") {
            $this->checkall   = true;
            $query                          = self::select(array_keys($this->_data['listField']))
                ->leftJoin(TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by');

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
            $options['insert_id']   = self::insertGetId($this->prepareParams($params));

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
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])

                ->first();
            if($result){
                $result = $result->toArray();
            }
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
        return '<select class="form-select mb-2" id="status" data-control="select2" name="status"
                        data-placeholder="Select an option" data-allow-clear="true">
                   ' . (!$default ? '<option value="" selected>--Select--</option>' : '') . '
                     <option value="active" ' . ($default == "active" ? "selected" : "") . '>Active</option>
                    <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Inactive</option>
                </select>';
    }

}
