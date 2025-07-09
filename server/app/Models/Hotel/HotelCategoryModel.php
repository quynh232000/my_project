<?php

namespace App\Models\Hotel;

use App\Models\Admin\UserModel;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kalnoy\Nestedset\NodeTrait;

class HotelCategoryModel extends AdminModel
{
    use NodeTrait;
    protected $guarded = ['id'];
    protected $path;
    public $crudNotAccepted = ['image_name'];
    protected $casts        = [
                                'type' => 'array'
                            ];
    private $bucket         = 's3_hotel';
    public function __construct($attributes = [])
    {
        $this->table        = TABLE_HOTEL_HOTEL_CATEGORY;

        $this->attributes   = $attributes;
        $this->_data        = [
            'listField'     => [
                $this->table . '.id'            => 'id',
                // $this->table . '.name'          => 'Tên',
                $this->table . '.slug'          => 'Slug',
                'p.name AS parent_name'         => 'Danh mục cha',
                $this->table . '.status'        => 'Trạng thái',
                'u.full_name AS created_by'     => 'Người tạo',
                $this->table . '.created_at'    => 'Ngày tạo',
                $this->table . '.updated_at'    => 'Ngày sửa',
                'u2.full_name AS updated_by'    => 'Người sửa',
            ],
            'fieldSearch'   => [
                $this->table . '.name' => 'Tên',
            ],
            'button'        => ['edit', 'delete'],
        ];
        parent::__construct();
    }
    private static function dataSelect () {
        return [
                    'destination'   => 'Điểm đến',
                    'popular'       => 'Phổ biến nhất',
                    'interest'      => 'Thu hút nhất',
                ];
    }
    public function adminQuery(&$query, $params)
    {
        if (isset($params['code']) && $params['code'] !== "") {
            $code = explode(',', preg_replace('/\s+/', ',', $params['code']));
            $code = array_filter($code, 'strlen');
            $query->whereIn($this->table . '.code', $code);
        }
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
        if (isset($params['type']) && $params['type'] != "") {
            $query->whereJsonContains('type',$params['type']);
        }

        return $query;
    }
    public function listItem($params = null, $options = null)
    {
        $this->_data['status'] = false;
        if ($options['task'] == "admin-index") {

            if($params['fixtree'] ?? false){
                HotelCategoryModel::fixTree();
            }
            $query                              = self::withDepth()
                                                    ->defaultOrder() ;

            $query                              = self::adminQuery($query, $params);
            $this->_data['items']               = $query->paginate($params['item-per-page']);
        }
        return $this->_data;
    }

    public function uploadImageFile(&$params) {

        $folderPath                 = $params['controller'] .'/images/'. $params['insert_id'] . '/';
        $image                      = $params['image'];
        $imageName                  = $params['slug'] .'_' . time() . '.' . $image->extension();
        Storage::disk($this->bucket)->put($folderPath . $imageName, file_get_contents($image));
        $params['image']         = $imageName;

    }
    public function saveItem($params = null, $options = null)
    {

        if ($options['task'] == 'add-item') {
            $params['priority']     = $params['priority'] ?? 9999;
            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');

            if($params['type'] ?? false){
                $params['type'] = json_encode($params['type']);
            }
            if ($params['parent_id'] > 0) {
                $item               = self::create($this->prepareParams($params), self::findOrFail($params['parent_id']));
            } else {
                $item               = self::create($this->prepareParams($params));
            }

            if (request()->hasFile('image')) {
                $params['insert_id']  = $item->id;
                self::uploadImageFile($params);

                $item->image            = $params['image'];
                $item->save();
            }

            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }

        if ($options['task'] == 'edit-item') {
            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            $params['priority']         = $params['priority'] ?? 9999;

            if (request()->hasFile('image')) {
                $params['insert_id']    = $params['id'];
                self::uploadImageFile($params);
            }

            self::findOrFail($params['id'])->update($this->prepareParams($params));

            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
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
        if ($options['task'] == 'arrange') {
            $act    = $params['action'];
            self::findOrFail($params['id'])->$act();
        }
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item-info') {
            $result = self::select($this->table . '.*')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();
            if ($result != null) {
                $result             = $result->toArray();
                $params['item']     = $result;
                $result['imageName']= $result['image'];
                $result['image']    = $this->getImageUrlS3($result['image'], $params);
                $result['status']   = trim($result['status']);
            }
        }
        if($options['task'] == 'get-all'){
            $result = self::select('id','name','parent_id')->withDepth()->defaultOrder()->get();
        }

        return $result;
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
    public static function slbStatus($default = 'inactive',$params = [])
    {
        $showDefaultOption = isset($params['action']) && $params['action'] == 'index';

        return '<select id="status" name="status" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                   ' . ($showDefaultOption ? '<option value="" selected>Chọn trạng thái</option>' : '') . '
                    <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
                    <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
                </select>';
    }
    public static function createTreeTable($params, $nodes)
    {
        $xhtml      = '';
        $traverse   = function ($categories, $prefix = '', $parent = '') use (&$traverse, $xhtml, $params) {

            foreach ($categories as $key => $category) {
                $btnAction   = \App\Helpers\Template::adminButtonAction($params, $params['model']['button'], $category['id']);
                $cls         = 'EEF1F3';
                if ($category->depth == 1 || $category->depth == 2) {
                    $cls     = 'FFFFFF';
                }
                $btnMove     = '';

                $hasChild    = false;

                if (count($category['children']) > 0) {
                    $parent     = ' ('.count($category['children']).') <i class="fa-sharp fa-solid fa-caret-down text-dark"></i>';
                    $hasChild   = true;
                } else {
                    $parent     = '';
                    if(count($categories) > 1 ){
                        $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'down', 'id' => $category['id']]) . '" title="Xuống" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-danger">
                                    <i class="fa-sharp fa-solid fa-arrow-down"></i>
                                    </a>
                                    <a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'up', 'id' => $category['id']]) . '" title="Lên" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-success">
                                        <i class="fa-sharp fa-solid fa-arrow-up"></i>
                                    </a>';
                    }
                    if ($key > 0 && ($key) == count($categories) -1 ) {
                        $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'up', 'id' => $category['id']]) . '" title="Lên" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-success">
                                        <i class="fa-sharp fa-solid fa-arrow-up"></i>
                                    </a>';
                    }
                    if ($key == 0 ) {
                        $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'down', 'id' => $category['id']]) . '" title="Xuống" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-danger">
                                        <i class="fa-sharp fa-solid fa-arrow-down"></i>
                                    </a>';
                    }
                    if(count($categories) == 1 ){
                        $btnMove = '';
                    }
                }

                $xhtml .= '<tr style="background-color:#' . $cls . '">
                                <td class="text-left align-middle p-1"><strong>' . $prefix . $category->name . $parent . '</strong></td>
                                <td class="text-left align-middle p-1">' . $category->slug . '</td>
                                <td class="text-center align-middle p-1">' . $btnMove . '</td>
                                <td class="text-center align-middle p-1">' . self::column_type($category->type ?? '') . '</td>
                                <td class="text-center align-middle p-1">' . \App\Helpers\Template::btnStatus($params, $category->id,  $category->status) . '</td>
                                <td class="text-left align-middle p-1">' . ($category->creator->full_name ?? '') . '</td>
                                <td class="text-left align-middle p-1">' . ($category->created_at ?? '') . '</td>
                                <td class="text-left align-middle p-1">' . ($category->modifier->full_name ?? '') . '</td>
                                <td class="text-left align-middle p-1">' . $category->updated_at . '</td>
                                <td class="text-center align-middle p-1">' . $btnAction . '</td>
                            </tr>';

                $xhtml .= $traverse($category['children'], $prefix . '<i class="fa-sharp fa-solid fa-minus text-primary"></i>', $parent);
            }
            return $xhtml;
        };

        return '<table id="table-list-customer" class="table table-bordered">' .
                    '<thead class="bg-white">' .
                    '<th class="text-left font-weight-bold">Tên danh mục</th>' .
                    '<th class="text-left font-weight-bold">Slug</th>' .
                    '<th class="text-left font-weight-bold">Sắp xếp</th>' .
                    '<th class="text-left font-weight-bold">Loại</th>' .
                    '<th class="text-left font-weight-bold" width="7%">Trạng thái</th>' .
                    '<th class="text-left font-weight-bold">Người tạo</th>' .
                    '<th class="text-left font-weight-bold">Ngày tạo</th>' .
                    '<th class="text-left font-weight-bold">Người sửa</th>' .
                    '<th class="text-left font-weight-bold">Ngày sửa</th>' .
                    '<th class="text-center font-weight-bold" width="8%">Thao tác</th>' .
                    '</thead>' .
                    '<tbody id="tbl_results">' .
                        $traverse($nodes, '') .
                    '<tbody id="tbl_results">' .
                '</table>';
    }
    public static function treeSelectCategory($selected_id = null,$current_id = null)
    {
        $xhtml          = '';
        $disable        = false;
        $selectedDepth  = null;

        $categories     = self::select('id','name','parent_id')->withDepth()
                        ->defaultOrder()
                        ->get()->toArray();

        foreach ($categories as $category) {
            $selected           = $selected_id == $category['id'] ? 'selected' : '';
            if ($category['id'] == $current_id) {
                $disable        = true;
                $selectedDepth  = $category['depth'];
            } else {
                if ($category['depth'] <= $selectedDepth) {
                    $disable        = false;
                    $selectedDepth  = null;
                }
            }

            $rawDepth   = $category['depth'] ?? 0;
            $depth      = is_numeric($rawDepth) ? max(0, (int) $rawDepth) : 0;
            $xhtml      .= '<option style="'.(empty($category['depth']) ?' font-weight:bold':'').';" '.($disable ? 'disabled':'').' '.$selected.' value="' . $category['id'] . '">' .str_repeat('--', $depth) . $category['name'] . '</option>';
        }
        return $xhtml;
    }

    public static function selectType($selecteds = [],$is_muti = true)
    {

        $opts           = '';
        $selecteds      = is_array($selecteds) ? $selecteds : (json_decode($selecteds,true) ?? []);

        foreach (self::dataSelect() as $key => $value) {

            $selected   = (in_array($key,$selecteds ?? []) ?? false) ? 'selected' : '';
            $opts       .= '<option '.$selected.' value="'.$key.'">'.$value.'</option>';

        }

        $muti           = $is_muti ? ' name="type[]" multiple ':' name="type"';

        return  '<select  class="form-control select2" '.$muti.' data-placeholder="--- Chọn ---">
                    '.($is_muti ? '':'<option value="">--Chọn--</option>').'
                    '.$opts.'
                </select>';
    }
    private static function column_type($value = []) {

        $data           = is_array($value) ? $value : json_decode($value, true);
        if (!is_array($data)) $data = [];

        $mapped         = [];
        foreach ($data as $item) {
            $mapped[]   = self::dataSelect()[$item] ?? $item;
        }
        return implode(',<br>', $mapped);;
    }
     public function creator()
    {
        return $this->belongsTo(UserModel::class, 'created_by');
    }
    public function modifier()
    {
        return $this->belongsTo(UserModel::class, 'updated_by');
    }

}
