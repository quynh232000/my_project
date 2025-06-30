<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminModel extends Model
{

    protected $table            = '';
    protected $crudNotAccepted  = ['_token', 'prefix', 'controller', 'action', 'as', '_method', 'ID','avatar_remove'];
    protected $_data                  = [];
    public $timestamps          = false;
    public $checkall            = true;
    public function __construct()
    {
        $this->primaryKey = $this->columnPrimaryKey();
    }
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    // okaosdkaos

    public function getTable()
    {
        if ($this->table) return $this->table;

        $className  = class_basename($this);
        $baseName   = str_replace('Model', '', $className);
        $table      = Str::snake($baseName);
        return 'TABLE_' . strtoupper($table);
    }

    static function slbItemPerPage($params)
    {

        return '<span>Showing</span>
                <div class="btn-group border rounded">
                    <select id="item-per-page" name="item-per-page" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                        <option ' . ($params['item-per-page'] == '10' ? 'selected' : '') . ' value="10">10</option>
                        <option ' . ($params['item-per-page'] == '25' ? 'selected' : '') . ' value="25">25</option>
                        <option ' . ($params['item-per-page'] == '50' ? 'selected' : '') . ' value="50">50</option>
                        <option ' . ($params['item-per-page'] == '100' ? 'selected' : '') . ' value="100">100</option>
                        <option ' . ($params['item-per-page'] == '250' ? 'selected' : '') . ' value="250">250</option>
                        <option ' . ($params['item-per-page'] == '500' ? 'selected' : '') . ' value="500">500</option>
                    </select>
                </div>
                <!-- /.btn-group -->';
    }

    public function headTable($options = null)
    {

        $xhtml  = '';
        $sort   = @$_GET['sort'];
        $order  = isset($_GET['order']) && $_GET['order'] == 'asc' ? 'desc' : 'asc';

        unset($_GET['sort']);
        unset($_GET['order']);
        $linkSort = http_build_query($_GET) != '' ? '&' . http_build_query($_GET) : '';
        $fieldShow = isset($options['fieldShow']) ? $options['fieldShow'] : $this->_data['listField'];

        foreach ($this->_data['listField'] as $field => $label) {
            $className  = (isset($options['task']) && $options['task'] == 'add-class') ? 'col-head-table col-' . $field : '';
            $display    = array_key_exists($field, $fieldShow) ? '' : ' d-none';
            $tmp        = explode('.', $field);
            $tmp        = explode(' AS ', end($tmp));
            $field      = end($tmp);
            $name_field = mb_convert_case(str_replace('_', ' ', $field), MB_CASE_TITLE, 'UTF-8');
            if ($field !== $this->primaryKey) {

                $link   = '?sort=' . $field . '&order=' . $order . $linkSort;

                $icon    = '<i class="fa-sharp fa-solid fa-sort fa-xs"></i>';
                if ($sort == $field) {
                    $icon = $order == 'asc' ? '<i class="fa-sharp fa-solid fa-sort-down text-primary"></i>' : '<i class="fa-sharp fa-solid fa-sort-up text-primary"></i>';
                }
                $xhtml .= sprintf('<th class="text-center align-middle p-1%s"><a href="%s" class="text-dark">%s</a></th>', $className . $display, $link,$name_field . '&nbsp;' . $icon);
            } else {
                if ($this->checkall == true) {

                    $xhtml .= '<th width="5%" class="text-center pl-0 pb-2 ps-5">
                                    <div title="Check all" class="form-check form-check-sm form-check-custom checkbox-toggle form-check-danger  me-3">
                                        <input class="form-check-input list_check_all" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1">
                                    </div>
                                </th>';
                }
            }
        }
        return $xhtml;
    }

    public function getActionButton($params, $data,  $val, $options = null)
    {
        return \App\Helpers\Template::adminButtonAction($params, $data['button'],  $val[$this->primaryKey]);
    }

    public function contentHtml($params, $data, $options = null)
    {
        $flagButton = isset($data['button']) && count($data['button']) > 0 ? true : false;

        $allHtml = '<div style="overflow-x: auto; width: 100%">
                        <table id="table-list-' . $params['prefix'] . '-' . $params['controller'] . '" class="table nowrap table-bordered no-footer text-left table-striped fs-lg">
                            <thead>'
            . $data['headTable'] .
            ($flagButton == true ? '<th width="10%" class="text-center">ACTIONS</th>' : '') .
            '</thead>
                            <tbody id="' . $params['prefix'] . '-' . $params['controller'] . '">';

        if (count($data['items']) > 0) {
            $i = 0;

            foreach ($data['items'] as $key => $val) {

                $class  = ($i % 2 == 0) ? "even" : "odd";

                $xhtml  = '';
                $val    = collect($val);
                $val    = $val->toArray();
                $val[$this->primaryKey] = trim($val[$this->primaryKey]);
                $id     = trim(@$val[$this->primaryKey]);
                foreach ($data['listField'] as $field => $label) {
                    $tmp   = explode('.', $field);
                    $tmp   = explode(' AS ', end($tmp));
                    $field = end($tmp);
                    $xhtml .= $this->createRow($params, $field, $val, $id);
                }
                $btnAction   = ($flagButton == true ? '<td class=" last text-center" width="5%">' . $this->getActionButton($params, $data, $val) . '</td>' : '');

                $allHtml .= '<tr class="' . $class . ' pointer">' . $xhtml . $btnAction . '</tr>';
                $i++;
            }
        } else {
            $count = isset($data['countCol']) ? $data['countCol'] : (count($data['listField']) > 0 ? (count($data['listField']) + 1) : 9);
            $allHtml .=  '<tr><td colspan="' . $count . '" class="text-center">No Data Found !!</td></tr>';
        }
        $allHtml .=  '</tbody>
                    </table></div>';
        if (count($data['items']) > 0 && !is_array($data['items'])) {
            $allHtml .= self::paginateBackend($data['items'], $params);
        }
        return $allHtml;
    }

    public static function paginateBackend($items, $params)
    {
        return '<div class="x_content mt-5">
                    <div class="row">

                        <div class="col-md-12 d-flex justify-content-center">
                            ' . $items->links() . '
                        </div>
                    </div>
                </div>';
    }
    public function createRow($params, $field, $val, $id, $options = null)
    {

        if ($field != $this->primaryKey) {
            if ($field == 'status') {
                $elemen = $this->columnStatus($params, $field, $val);
            } elseif ($field == 'created_at' || $field == 'updated_at') {

                $elemen = $this->columnDate($field, $val);
            } else {
                $func = 'column' . ucwords($field);
                if (method_exists(static::class, $func)) {
                    $elemen = $this->$func($params, $field, $val);
                } else {
                    $elemen = $this->columnGeneral($params, $field, $val);
                }
            }
            $display = '';
            if (isset($options['task']) && $options['task'] == 'show-custom-field') {
                $display = array_key_exists($field, $options['fieldShow']) ? '' : ' d-none';
            }
            $className = (isset($options['task']) && $options['task'] == 'show-custom-field') ? ' row-table row-' . $field : '';
            return sprintf('<td class=" text-' . (!preg_match('#[^\d\.]#', $elemen) ? 'right' : 'left') . ' align-middle%s">%s</td>', $className . $display, $elemen);
        } else {
            if ($this->checkall == true) {
                return $this->columnPrimary($params, $val);
            }
            return '';
        }
    }
    public function columnStatus($params, $field, $val)
    {
        if ($val[$field] == null || $val[$field] == '') {
            $val[$field] = 'none';
        }
        return '<center>' . \App\Helpers\Template::btnStatus($params, trim($val[$this->primaryKey]), trim($val[$field])) . '</center>';
    }

    public function columnPrimary($params, $val)
    {
        $id         = $this->primaryKey;
        $checked    = '';
        if (isset($params[$id]) && !empty($params[$id]) && in_array($val[$id], explode(',', $params[$id]))) {
            $checked   = ' checked';
        }
        return sprintf('<td class=" text-center ps-5 ">
                                    <div title="Chọn tất cả" class="form-check form-check-sm form-check-custom checkbox-toggle form-check-solid me-3 mt-3">
                                        <input class="form-check-input"
                                        type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input"
                                        id="id-%s" name="id[]" value="%s" %s>
                                    </div>
                        </td>', $val[$id], $val[$id], $checked);
    }
    public function columnGeneral($params, $field, $val)
    {
        return @$val[$field];
    }
    public function columnDate($field, $val, $format = 'Y-m-d H:i:s')
    {
        return !empty($val[$field]) ? date($format, strtotime($val[$field])) : '_';
    }

    public function columnPrimaryKey($key = 'id')
    {
        return $key;
    }
    public function prepareParams($params)
    {
        $crudNotAccepted = [
            '_token',
            'prefix',
            'controller',
            'action',
            'as',
            '_method',
            'totalItemsPerPage'
        ];
        $crudNotAccepted = array_merge($this->crudNotAccepted, $crudNotAccepted);

        return array_diff_key($params, array_flip($crudNotAccepted));
    }
}
