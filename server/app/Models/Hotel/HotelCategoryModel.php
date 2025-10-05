<?php

namespace App\Models\Hotel;

use App\Models\Admin\UserModel;
use App\Models\AdminModel;
use App\Services\FileService;
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
        // 'position' => 'array'
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
    private static function dataSelect()
    {
        return [
            'trending'      => 'Khách sạn Flash Sale',
            'best_price'    => 'Khách sạn giá tốt',
            'destination'   => 'Điểm đến',
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
            $query->where('type', $params['type']);
        }
        if (isset($params['position']) && $params['position'] != "") {
            $query->whereJsonContains('position', $params['position']);
        }

        return $query;
    }
    public function listItem($params = null, $options = null)
    {
        $this->_data['status'] = false;
        if ($options['task'] == "admin-index") {

            if ($params['fixtree'] ?? false) {
                HotelCategoryModel::fixTree();
            }
            $query                              = self::withDepth()
                ->defaultOrder();

            $query                              = self::adminQuery($query, $params);
            $this->_data['items']               = $query->paginate($params['item-per-page']);
        }
        return $this->_data;
    }

    public function uploadImageFile(&$params)
    {

        $folderPath                 = $params['controller'] . '/images/' . $params['insert_id'] . '/';
        $image                      = $params['image'];
        $imageName                  = $params['slug'] . '_' . time() . '.' . $image->extension();
        Storage::disk($this->bucket)->put($folderPath . $imageName, file_get_contents($image));
        $params['image']         = $imageName;
    }
    public function saveItem($params = null, $options = null)
    {

        if ($options['task'] == 'add-item') {
            $params['priority']     = $params['priority'] ?? 9999;
            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');


            if ($params['position'] ?? false) {
                $params['position']     = json_encode($params['position']);
            }
            if (request()->hasFile('image')) {
                $params['image'] = FileService::file_upload($params, $params['image'], 'image');
            }
            if ($params['parent_id'] > 0) {
                $item               = self::create($this->prepareParams($params), self::findOrFail($params['parent_id']));
            } else {
                $item               = self::create($this->prepareParams($params));
            }





            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }

        if ($options['task'] == 'edit-item') {
            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            $params['priority']         = $params['priority'] ?? 9999;

            if (request()->hasFile('image')) {
                $params['image'] = FileService::file_upload($params, $params['image'], 'image');
            }
            if ($params['position'] ?? false) {
                $params['position']     = json_encode($params['position']);
            } else {
                $params['position']     = null;
            }
            self::findOrFail($params['id'])->update($this->prepareParams($params));

            // update to elastic search


            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
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
                $result['imageName'] = $result['image'];
                $result['status']   = trim($result['status']);
            }
        }
        if ($options['task'] == 'get-all') {
            $result = self::select('id', 'name', 'parent_id')->withDepth()->defaultOrder()->get();
        }

        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {
            } elseif (is_array($params['id'])) {
                // update to elastic search


                self::whereIn($this->primaryKey, $params['id'])->whereNotIn('status', ['finish', 'pending-print', 'signed'])->delete();
            }
        }
    }
    public static function slbStatus($default = 'inactive', $params = [])
    {
        $showDefaultOption = isset($params['action']) && $params['action'] == 'index';

        return '<select id="status" name="status" class="form-control " data-control="select2" style="width: 100%;">
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
                    $parent     = ' (' . count($category['children']) . ')';
                    $hasChild   = true;
                } else {
                    $parent     = '';
                    if (count($categories) > 1) {
                        $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'down', 'id' => $category['id']]) . '" title="Xuống" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-danger">
                                    <i class="fa-sharp fa-solid fa-arrow-down"></i>
                                    </a>
                                    <a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'up', 'id' => $category['id']]) . '" title="Lên" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-success">
                                        <i class="fa-sharp fa-solid fa-arrow-up"></i>
                                    </a>';
                    }
                    if ($key > 0 && ($key) == count($categories) - 1) {
                        $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'up', 'id' => $category['id']]) . '" title="Lên" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-success">
                                        <i class="fa-sharp fa-solid fa-arrow-up"></i>
                                    </a>';
                    }
                    if ($key == 0) {
                        $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'down', 'id' => $category['id']]) . '" title="Xuống" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-danger">
                                        <i class="fa-sharp fa-solid fa-arrow-down"></i>
                                    </a>';
                    }
                    if (count($categories) == 1) {
                        $btnMove = '';
                    }
                }


                // class
                $rowId          = 'node-' . $category->id;
                $parentClass    = $category['parent_id'] ? 'child-of-' . $category['parent_id'] : '';
                $hasChildren    = count($category['children']) > 0;
                $toggleIcon     = $hasChildren ? '<i class="fa fa-caret-down toggle-node" data-id="' . $category->id . '"></i>' : '';

                $rowClass       = 'tree-node ' . $parentClass;
                if ($hasChildren) $rowClass .= ' has-child';
                // class
                $xhtml .= '<tr id ="' . $rowId . '" class="' . $rowClass . '" data-id="' . $category->id . '" data-parent-id="' . ($category['parent_id'] ?? '') . '" style="background-color:#' . $cls . '">' .
                    '<td class="text-left align-middle p-1">' . $prefix .  ' <strong>' . $category->name . $parent . $toggleIcon . '</strong></td>' .
                    '<td class="text-left align-middle p-1">' . $category->slug . '</td>' .
                    '<td class="text-center align-middle p-1">' . $btnMove . '</td>' .
                    '<td class="text-center align-middle p-1 "> <div class="badge badge-warning text-white">' . ($category->is_default ? 'Default' : '') . '</div></td>' .
                    '<td class="text-center align-middle p-1">' . self::column_type($category->type ?? '') . '</td>' .
                    '<td class="text-center align-middle p-1">' . self::column_position($category->position ?? '') . '</td>' .
                    '<td class="text-center align-middle p-1">' . \App\Helpers\Template::btnStatus($params, $category->id,  $category->status) . '</td>' .
                    '<td class="text-left align-middle p-1">' . ($category->creator->full_name ?? '') . '</td>' .
                    '<td class="text-left align-middle p-1">' . ($category->created_at ?? '') . '</td>' .
                    '<td class="text-left align-middle p-1">' . ($category->modifier->full_name ?? '') . '</td>' .
                    '<td class="text-left align-middle p-1">' . $category->updated_at . '</td>' .
                    '<td class="text-center align-middle p-1">' . $btnAction . '</td>' .
                    '</tr>';

                $xhtml .= $traverse($category['children'], $prefix . '<i class="fa-sharp fa-solid fa-minus text-primary"></i>', $parent);
            }
            return $xhtml;
        };

        return '<table id="table-list-customer" class="table table-bordered">' .
            '<thead class="bg-white">' .
            '<th class="text-left font-weight-bold">Tên danh mục</th>' .
            '<th class="text-left font-weight-bold">Slug</th>' .
            '<th class="text-left font-weight-bold">Sắp xếp</th>' .
            '<th class="text-left font-weight-bold" title="Lấy theo đơn vị hành chính">Mặc định</th>' .
            '<th class="text-left font-weight-bold">Loại</th>' .
            '<th class="text-left font-weight-bold">Vị trí</th>' .
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
    public static function treeSelectCategory($selected_id = null, $current_id = null)
    {
        $xhtml          = '';
        $disable        = false;
        $selectedDepth  = null;

        $categories     = self::select('id', 'name', 'parent_id')->withDepth()
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
            $xhtml      .= '<option style="' . (empty($category['depth']) ? ' font-weight:bold' : '') . ';" ' . ($disable ? 'disabled' : '') . ' ' . $selected . ' value="' . $category['id'] . '">' . str_repeat('--', $depth) . $category['name'] . '</option>';
        }
        return $xhtml;
    }

    public static function selectPosition($selecteds = [], $is_muti = true)
    {

        $opts           = '';
        if ($is_muti) {
            $selecteds      = is_array($selecteds) ? $selecteds : (json_decode($selecteds, true) ?? []);
        }

        foreach (self::dataSelect() as $key => $value) {
            if ($is_muti) {
                $selected   = (in_array($key, $selecteds ?? []) ?? false) ? 'selected' : '';
            } else {
                $selected   = $selecteds == $key ? 'selected' : '';
            }
            $opts       .= '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
        }

        $muti           = $is_muti ? ' name="position[]" multiple ' : ' name="position"';

        return  '<select  class="form-control " ' . $muti . ' data-control="select2" data-placeholder="--- Chọn ---">
                    ' . ($is_muti ? '' : '<option value="">--Chọn--</option>') . '
                    ' . $opts . '
                </select>';
    }
    public static function selectType($default = null, $is_muti = true)
    {

        $opts           = '';

        $data           = [
            ["id" => 1, "name" => "Địa điểm", "slug" => "location", "description" => 'Hồ Chí Minh, Vũng tàu'],
            ["id" => 5, "name" => "Loại hình lưu trú", "slug" => "accommodation", "description" => 'Resort tại Đà Nẵng,..'],
            ["id" => 6, "name" => "Khu vực bán kính", "slug" => "location_radius", "description" => "Danh mục có toạ độ lat/lon, dùng để tìm khách sạn trong bán kính (gần sân bay, gần biển, gần trung tâm)"],
            ["id" => 7, "name" => "Điểm nổi bật cụ thể", "slug" => "landmark", "description" => "Danh mục trỏ tới 1 địa điểm nổi bật cụ thể (Chợ Bến Thành, Ga Huế), có thể dùng lat/lon, address"],
            ["id" => 12, "name" => "Khác", "slug" => "facility", "description" => "Loại khác: Khách sạn Vũng Tàu có bãi đậu xe,..."]
        ];

        foreach ($data as $key => $value) {

            $selected   = $value['slug'] == $default ? 'selected' : '';
            $opts       .= '<option ' . $selected . ' value="' . $value['slug'] . '"  title="' . $value['description'] . '"  >' . $value['name'] . '</option>';
        }

        $muti           = $is_muti ? ' name="type[]" multiple ' : ' name="type"';

        return  '<select id ="type"  class="form-control " ' . $muti . ' data-control="select2" data-placeholder="--- Chọn ---">
                    ' . ($is_muti ? '' : '<option value="">--Chọn--</option>') . '
                    ' . $opts . '
                </select>';
    }
    public static function selectTypeLocation($default = null, $is_muti = true)
    {

        $opts           = '';
        $data           = [
            ["id" => 1, "name" => "Quốc gia", "slug" => "country", "description" => null],
            ["id" => 2, "name" => "Tỉnh / Thành phố", "slug" => "province", "description" => null],
            ["id" => 4, "name" => "Phường / Xã", "slug" => "ward", "description" => null],
        ];
        foreach ($data as $key => $value) {

            $selected   = $value['slug'] == $default  ? 'selected' : '';
            $opts       .= '<option ' . $selected . ' value="' . $value['slug'] . '"  title="' . $value['description'] . '"  >' . $value['name'] . '</option>';
        }

        $muti           = $is_muti ? ' name="type_location[]" multiple ' : ' name="type_location"';

        return  '<select id ="type_location"  class="form-control " ' . $muti . ' data-control="select2" data-placeholder="--- Chọn ---">
                    ' . ($is_muti ? '' : '<option value="">--Chọn--</option>') . '
                    ' . $opts . '
                </select>';
    }
    public static function selectAccommodation($default = null)
    {
        $parent     = AttributeModel::select('id')->where('slug', 'accommodation_type')->first();
        $data       = AttributeModel::select('id', 'name')
            ->where('parent_id', $parent->id)
            ->get()
            ->toArray();
        $opts       = '';
        foreach ($data as $item) {
            $opts   .= '<option value="' . $item['id'] . '" ' . ($default == $item['id'] ? 'selected' : '') . '>' . $item['name'] . '</option>';
        }
        return '
                    <select class="form-control " data-control="select2" id="accommodation_id" name="accommodation_id">
                        <option value="">-- Chọn --</option>
                        ' . $opts . '
                    </select>
                ';
    }
    public static function selectOther($default = null)
    {

        $data       = ServiceModel::select('id', 'name')
            ->where('type', 'hotel')
            ->whereNotNull('parent_id')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        $opts       = '';
        foreach ($data as $item) {
            $opts   .= '<option value="' . $item['id'] . '" ' . ($default == $item['id'] ? 'selected' : '') . '>' . $item['name'] . '</option>';
        }
        return '
                    <select  class="form-control " data-control="select2" id="facility_id" name="facility_id">
                        <option value="">-- Chọn --</option>
                        ' . $opts . '
                    </select>
                ';
    }
    private static function column_position($value = [])
    {

        $data           = is_array($value) ? $value : json_decode($value, true);
        if (!is_array($data)) $data = [];

        $mapped         = [];
        foreach ($data as $item) {
            $mapped[]   = self::dataSelect()[$item] ?? $item;
        }
        return implode(',<br>', $mapped);;
    }
    private static function column_type($value = [])
    {
        $dataInfo      = [
            ["id" => 1, "name" => "Địa điểm", "slug" => "location", "description" => 'Hồ Chí Minh, Vũng tàu'],
            ["id" => 5, "name" => "Loại hình lưu trú", "slug" => "accommodation", "description" => 'Resort tại Đà Nẵng,..'],
            ["id" => 6, "name" => "Khu vực bán kính", "slug" => "location_radius", "description" => "Danh mục có toạ độ lat/lon, dùng để tìm khách sạn trong bán kính (gần sân bay, gần biển, gần trung tâm)"],
            ["id" => 7, "name" => "Điểm nổi bật cụ thể", "slug" => "landmark", "description" => "Danh mục trỏ tới 1 địa điểm nổi bật cụ thể (Chợ Bến Thành, Ga Huế), có thể dùng lat/lon, address"],
            ["id" => 12, "name" => "Khác", "slug" => "facility", "description" => "Loại khác: Khách sạn Vũng Tàu có bãi đậu xe,..."]
        ];
        $item           = collect($dataInfo)->firstWhere('slug', $value);
        return isset($item) ? "<div title='" . $item['description'] . "'>" . $item['name'] . "</div>" : '';
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
