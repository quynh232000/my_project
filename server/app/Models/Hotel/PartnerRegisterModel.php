<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PartnerRegisterModel extends AdminModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PARTNER_REGISTER;
        $this->_data    =  [
            'listField'           => [
                $this->table . '.id'            => 'id',
                $this->table . '.code'          => 'Code',
                $this->table . '.title'         => 'Khách sạn',
                $this->table . '.full_name'     => 'Tên',
                $this->table . '.email'         => 'Email',
                $this->table . '.phone'         => 'Số điện thoại',
                $this->table . '.status'        => 'Trạng thái',
                $this->table . '.note'          => 'Ghi chú',
                'u.full_name AS created_by'     => 'Nhân viên xử lý',
                $this->table . '.created_at'    => 'Ngày tạo',
                'u2.full_name AS updated_by'    => 'Nhân viên sửa',
                $this->table . '.updated_at'    => 'Ngày sửa',
            ],
            'fieldSearch'           => [
                $this->table . '.name'          => 'Tiêu đề',
                $this->table . '.slug'          => 'Slug',
            ],
            'button'                            => ['edit']
        ];
        parent::__construct();
    }

    public function adminQuery(&$query, $params)
    {
        if (isset($params['code']) && $params['code'] !== "") {
            $code       = explode(',', preg_replace('/\s+/', ',', $params['code']));
            $code       = array_filter($code, 'strlen');
            $query->whereIn($this->table . '.code', $code);
        }
        if (isset($params['created_by']) && $params['created_by'] !== "") {
            $created_by = explode(',', preg_replace('/\s+/', ',', $params['created_by']));
            $created_by = array_filter($created_by, 'strlen');
            $query->whereIn($this->table . '.created_by', $created_by);
        }

        if (isset($params['full_name_update']) && $params['full_name_update'] !== "all") {
            $query->where('u2.full_name', 'LIKE', '%' . $params['full_name_update'] . '%');
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
        if (isset($params['full_name']) && $params['full_name'] !== "all") {
            $query->where($this->table . '.full_name', 'LIKE', '%' . $params['full_name'] . '%');
        }
        if (isset($params['email']) && $params['email'] !== "all") {
            $query->where($this->table . '.email', 'LIKE', '%' . $params['email'] . '%');
        }
        if (isset($params['phone']) && $params['phone'] !== "all") {
            $query->where($this->table . '.phone', 'LIKE', '%' . $params['phone'] . '%');
        }

        if (isset($params['title']) && $params['title'] !== "") {
            $query->where($this->table . '.title', 'LIKE', '%' . $params['title'] . '%');
        }
        if (isset($params['full_name']) && $params['full_name'] !== "") {
            $query->where($this->table.'.full_name', 'LIKE', '%' . $params['full_name'] . '%');
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
                ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by')
                ;

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
        if ($options['task'] == 'get-item') {
           $result           = self::select($this->table.'.*','u.full_name as created_by','u2.full_name as updated_by' )->where($this->table.'.id',$params['id'])
                                    ->leftJoin(TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                                    ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by')
                                    ->first()
                                    ->toArray();
        }
        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'edit-item') {

            $status = ($params['status'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])
                ->update([
                    'status'     => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
        }
        if($options['task'] == 'choose'){
            if(isset($params['type']) && $params['type'] == 'choose'){
                self::where('id', $params['id'])
                    ->update([
                        'created_by'    => Auth::user()->id,
                        'status'        => 'processing',
                        'processing_at' => date('Y-m-d H:i:s')
                    ]);
            }else{
                $dataUpdate                 = [];
                if((isset($params['status']) && !empty($params['status']))){
                    $dataUpdate['status']   = $params['status'];
                }
                if(isset($params['admin_note']) && !empty($params['admin_note'])){
                    $dataUpdate['admin_note']     = $params['admin_note'];
                }
                if(count($dataUpdate) > 0){
                    self::where('id', $params['id'])
                        ->update([
                            'updated_by'    => Auth::user()->id,
                            'updated_at'    => date('Y-m-d H:i:s'),
                            ...$dataUpdate
                        ]);
                }
            }
            return ['status' => true,'message' => 'Cập nhật thành công!'];
        }
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
    public $dataType = [
        'pending'     => ['warning','Chờ xử lý'],
        'processing'  => ['info','Đang xử lý'],
        'success'     => ['success','Hoàn thành'],
        'faild'       => ['danger','Đã hủy'],
    ];

    public function columnStatus($params, $field, $val)
    {
        $value = isset($this->dataType[$val[$field]][1]) ? $this->dataType[$val[$field]][1] : $val[$field];
        $class = $this->dataType[$val[$field]][0] ?? '';
        return '<div class="d-flex justify-content-center "><div style="min-width:80px !important" class="badge badge-'. $class.' text-white">'.$value.'</div> </div>';
    }
    function isValidDateTime($date, $format = 'Y-m-d H:i:s') {
        try {
            return Carbon::createFromFormat($format, $date) !== false;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function createRow($params, $field, $val, $id, $options = null){
        if ($field != $this->primaryKey) {
            if ($field == 'status') {
                $elemen = $this->columnStatus($params, $field, $val);
            } elseif ($field == 'created_at' || $field == 'updated_at') {
                $elemen     = $this->columnDate($field, $val);
            } else {
                $func       = 'column' . ucwords($field);
                if (method_exists(static::class, $func)) {
                    $elemen = $this->$func($params, $field, $val);
                } else {
                    $elemen = $this->columnGeneral($params, $field, $val);
                }
            }
            $display        = '';
            if (isset($options['task']) && $options['task'] == 'show-custom-field') {
                $display    = array_key_exists($field, $options['fieldShow']) ? '' : ' d-none';
            }
            $classBg        = $val['status'] == 'pending' ? " bg-warning ":' ';
            $className      = $classBg;
            $className      .=  (isset($options['task']) && $options['task'] == 'show-custom-field') ? ' row-table row-' . $field : ' ';

            $click          = '';
            $class          = '';
            if($val['status'] == 'pending'){
                $url        = "'".route($params['prefix'] . '.' . $params['controller'] .  '.confirm-choose',['type' => 'choose'])."'";
                $click      = 'ondblclick="adminConfirm1('.$id.','.$url.')"';
                $class      = ' cursor-pointer ';
            }

            return sprintf('<td '.$click.' class="p-2 '.$class.' text-' . (!preg_match('#[^\d\.]#',$elemen) ? 'right' : 'left') . ' align-middle%s">%s</td>', $className . $display, $elemen);
        } else {
            if($this->checkall == true){
                return $this->columnPrimary($params, $val);
            }
            return '';
        }
    }
    public function columnGeneral($params, $field, $val)
    {
        return htmlspecialchars(@$val[$field], ENT_QUOTES, 'UTF-8');
    }
    public function getActionButton($params, $data,  $val, $options = null)
    {
        $id     = $val[$this->primaryKey];
        $icon   = $val['status'] == 'pending' ? '<i class="fa-sharp fa-solid fa-solid fa-check-to-slot text-secondary fa-lg btn-choose-ticket"></i>' : '<i class="fa-sharp fa-solid fa-pen-to-square text-secondary fa-lg "></i>';
        $title  = $val['status'] == 'pending' ? 'Chọn': 'Xử lý yêu cầu';
        $type   = $val['status'] == 'pending' ? 'choose': 'set-status';

        $click  = "onclick='adminConfirm1(\"".$id."\",\"".route($params['prefix'] . '.' . $params['controller'] .  '.confirm-choose',['type' => $type])."\")'";

        // button view detail
        $linkViewShow   = route($params['prefix'] . '.' . $params['controller'] .  '.show',['partner_register' => $id]);
        $viewShow       = '<a href="'.$linkViewShow.'" type="button" class="btn btn-sm btn-icon btn-view px-1 py-0" data-toggle="tooltip" data-placement="top" data-original-title="Xem">
                            <i class="fa-sharp fa-solid fa-sharp fa-solid fa-eye text-secondary fa-lg "></i>
                        </a>';

        return $viewShow.'<a '.$click.'
                    " type="button" class="btn btn-sm btn-icon btn-choose-ticket px-1 py-0" data-toggle="tooltip" data-placement="top" data-original-title="'.$title.'">
                    '.$icon.'
                </a>';
    }
    public static function slbStatus($default = '',$params = [])
    {
        $dataType = [
            'success'          => 'Hoàn thành',
            'faild'            => 'Hủy bỏ',
        ];
        if(isset($params['all']) && $params['all']){
            $dataType   = [
                'pending'      => 'Chờ xử lý',
                'processing'   => 'Đang xử lý',
                'success'      => 'Đã xử lý',
                'faild'        => 'Đã hủy',
            ];
        }
        $html           = '';
        foreach ($dataType as $key => $value) {
            $html       .= '<option value="'. $key. '" ' . ($default == $key ? "selected" : "") . '>'. $value. '</option>';
        }
        return '<select id="status" name="status" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" style="width: 100%;">
                   ' . '<option value="" selected>--Chọn trạng thái--</option>'
                   .$html.
                '</select>';
    }


}
