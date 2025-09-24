<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use App\Models\General\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kalnoy\Nestedset\NodeTrait;

class AttributeModel extends AdminModel
{
    use NodeTrait;
    protected $table    = TABLE_HOTEL_ATTRIBUTE;
    protected $bucket   = 's3_hotel';
    public function __construct($attributes = [])
    {
        $this->attributes   = $attributes;
        $this->_data = [
            'listField' => [
                $this->table . '.id'            => 'id',
                $this->table . '.name'          => 'Name',
                $this->table . '.slug'          => 'Slug',
                'p.name AS parent_name'         => 'parent_name',
                $this->table . '.status'        => 'status',
                'u.full_name AS created_by'     => 'created_by',
                $this->table . '.created_at'    => 'created_at',
                $this->table . '.updated_at'    => 'updated_at',
                'u2.full_name AS updated_by'    => 'updated_by',
            ],
            'fieldSearch'   => [
                $this->table . '.name' => 'Tên',
            ],
            'button'        => ['edit', 'delete'],
        ];
        parent::__construct();
    }
    protected $guarded = [];
    public $arrayKey = [
        'image_type',
        'image_room',
        'image_hotel',
        'image_facility',
        'image_food',
        'image_local_sight',
        'image_other',
        'room_type',
        'bed_type',
        'accommodation_type',
        'direction_type',
        'breakfast_type',
        'serving_type',
        'duccument_require',
        'adult_require',
        'method_deposit'
    ];
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
        if (isset($params['full_name_update']) && $params['full_name_update'] !== "all") {
            $query->where('u2.full_name', 'LIKE', '%' . $params['full_name_update'] . '%');
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
        if ($options['task'] == "admin-index") {
            if ($params['fixtree'] ?? false) {
                AttributeModel::fixTree();
            }
            $this->checkall                 = true;
            $type           = $params['type'] ?? null;
            if (empty($type)) {
                $type       = self::first() ?? null;
                if (!$type) {
                    $type   = self::orderBy('id', 'ASC')->withDepth()->having('depth', '=', 0)->first() ?? null;
                }
            } else {
                $type   = self::where('slug', $type)->first();
            }

            $query                              = self::withDepth()
                ->defaultOrder();
            if ($type) {
                $query->whereDescendantOrSelf($type->id);
                $this->_data['type'] = $type->slug;
            }

            $query                              = self::adminQuery($query, $params);
            $this->_data['items']               = $query->paginate($params['item-per-page']);
        }
        if ($options['task'] == "list") {
            $this->_data = self::select('id', 'name', 'parent_id')->withDepth()
                ->defaultOrder()
                ->get()->toArray();
        }
        if ($options['task'] == "list-type") {
            $this->_data = self::select('id', 'name', 'slug')->whereNull('parent_id')->get()->toArray();
        }
        return $this->_data;
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item-info') {
            $result               = self::select($this->table . '.*')
                ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();
            if ($result != null) {
                $result           = $result->toArray();
                $params['item']   = $result;
                $result['status'] = trim($result['status']);
            }
        }
        return $result;
    }
    public static function slbStatus($default = null, $params = [])
    {
        return '<select class="form-select mb-2" id="status" data-control="select2" name="status"
                        data-placeholder="Select an option" data-allow-clear="true">
                   ' . (!$default ? '<option value="" selected>Chọn trạng thái</option>' : '') . '
                     <option value="active" ' . ($default == "active" ? "selected" : "") . '>Active</option>
                    <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Inactive</option>
                </select>';
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
            $params['created_by'] = Auth::user()->id;
            $params['created_at'] = date('Y-m-d H:i:s');

            $parent               = $params['parent_id'] ? self::findOrFail($params['parent_id']) : null;

            $newNode =  AttributeModel::create($this->prepareParams($params));
            if ($parent) {
                $parent->appendNode($newNode);
            } else {
                $newNode->makeRoot();
            }
            $newNode->save();


            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }

        if ($options['task'] == 'edit-item') {

            $params['updated_by']     = Auth::user()->id;
            $params['updated_at']     = date('Y-m-d H:i:s');

            $this->where($this->primaryKey, $params[$this->primaryKey])->update($this->prepareParams($params));
            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }

        if ($options['task'] == 'change-status') {
            $status              = ($params['status'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])
                ->update([
                    'status'     => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {
            } elseif (is_array($params['id'])) {
                self::whereIn($this->primaryKey, $params['id'])->whereNotIn('status', ['finish', 'pending-print', 'signed'])
                    ->whereNotIn('slug', $this->arrayKey)->delete();
            }
        }
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
                    // $parent     = ' ('.count($category['children']).') <i class="fa-sharp fa-solid fa-caret-down text-dark"></i>';
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

                $xhtml .= '<tr style="background-color:#' . $cls . '">
                                <td class="text-left align-middle p-1"><strong>' . $prefix . $category->name . $parent . '</strong></td>
                                <td class="text-left align-middle p-1">' . $category->slug . '</td>
                                <td class="text-center align-middle p-1">' . $btnMove . '</td>
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
    public static function treeSelectCategory($categories, $selected_id = null, $current_id = null)
    {
        $xhtml          = '';
        $disable        = false;
        $selectedDepth  = null;

        foreach ($categories as $category) {
            $selected           = $selected_id && $selected_id == $category['id'] ? 'selected' : '';
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
            $xhtml .= '<option style="' . (empty($category['depth']) ? ' font-weight:bold' : '') . ';" ' . ($disable ? 'disabled' : '') . ' ' . $selected . ' value="' . $category['id'] . '">' . str_repeat('--', $depth) . $category['name'] . '</option>';
        }
        return $xhtml;
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
