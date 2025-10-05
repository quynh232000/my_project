<?php

namespace App\Models\Portfolio;

use App\Models\AdminModel;
use App\Services\FileService;
use Auth;

class JobModel extends AdminModel
{
    protected $guarded      = ['id'];
    private $bucket         = 's3_hotel';
    public function __construct($attributes = [])
    {
        $this->table        = config('constants.table.portfolio.' . self::getTable());
        $this->attributes   = $attributes;

        $this->_data        =  [
            'listField'     => [
                $this->table . '.id'            => 'id',
                $this->table . '.position'          => 'position',
                $this->table . '.company'          => 'company',
                $this->table . '.address'          => 'address',
                $this->table . '.job_link'          => 'job_link',
                $this->table . '.cv_link'          => 'cv_link',
                $this->table . '.cv_canvas'          => 'cv_canvas',
                $this->table . '.state'          => 'state',
                // $this->table . '.description'          => 'description',
               
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
    public $arrData = [
        'type' => [
            'international'         => 'Quốc tế',
            'domestic'              => 'Nội địa',
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
            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');
            // insert data
            $item                   = self::create($this->prepareParams($params));
            $params['insert_id']    = $item->id;

            // upload file
            $hasFile                = false;
            if ($params['cv_link'] ?? false) {
                $params['cv_link']  = FileService::file_upload($params, $params['cv_link'], 'cv_link');
                $hasFile            = true;
            }
            

            // check if has file then update
            if ($hasFile) {
                self::where('id', $params['insert_id'])->update([
                    'cv_link'          => $params['cv_link'] ?? ''
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Tạo yêu mới cầu thành công!', 'id' => $params['insert_id']]);
        }
        if ($options['task'] == 'edit-item') {

            $params['updated_by']           = Auth::user()->id;
            $params['updated_at']           = date('Y-m-d H:i:s');

            // upload file
            $fileUpload                     = [];
            $hasFile                = false;
            $params['insert_id']            = $params['id'];
            if (request()->hasFile('cv_link') ?? false) {
                $params['cv_link']  = FileService::file_upload($params, $params['cv_link'], 'cv_link');
                $hasFile            = true;
            }
            // update data
            $item = self::where('id', $params['id'])->firstOrFail();
            $item->update([...$this->prepareParams($params), ...$fileUpload]);

            return response()->json(['success' => true, 'message' => 'Cập nhật yêu cầu thành công!']);
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
    public static function stateSelect($default = null, $params = [])
    {
        $data = [
            'new' => 'New',
            'success' => 'Pass',
            'failed' => 'Failed',
        ];
        $opt = '';
        foreach ($data as $key => $value) {
            $select = $default == $key ? 'selected': '';
            $opt .= "<option value='{$key}' {$select}>{$value}</option>";
        }
        return '<select id="state" name="state" class="form-control" data-control="select2" style="width: 100%;">
                  <option value="" selected>--Select--</option>
                    '.$opt.'
                </select>';
    }
    public function columnCv_Link($params, $field, $val)
    {
        return "<a class='btn btn-primary' href='{$val[$field]}'>Link CV</a>";
    }
    public function columnJob_Link($params, $field, $val)
    {
        return "<a class='btn btn-primary' href='{$val[$field]}'>Link CV</a>";
    }
    public function columnCv_canvas($params, $field, $val)
    {
        return "<a class='btn btn-primary' href='{$val[$field]}'>Link CV</a>";
    }
    public function columnState($params, $field, $val)
    {
         $data = [
            'new' => 'New',
            'success' => 'Pass',
            'failed' => 'Failed',
        ];
        return $data[$val[$field]] ?? '';
    }
}
