<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class PostCategoryModel extends AdminModel
{
    use NodeTrait;
    protected $guarded = ['id'];
    protected $path;
    public $crudNotAccepted = ['image_name'];
    public function __construct($attributes = [])
    {
        $this->table        = TABLE_HOTEL_POST_CATEGORY;

        $this->attributes   = $attributes;
        $this->_data        = [
            'listField' => [ // liệt kê các field sẽ hiển thị ở trang danh sách theo key - value được khai báo
                $this->table . '.id'            => 'id',
                $this->table . '.name'          => 'Tên',
                $this->table . '.slug'          => 'Slug',
                'p.name AS parent_name'         => 'Danh mục cha',
                $this->table . '.status'        => 'Trạng thái',
                'u.full_name AS created_by'     => 'Người tạo',
                $this->table . '.created_at'    => 'Ngày tạo',
                $this->table . '.updated_at'    => 'Ngày sửa',
                'u2.full_name AS updated_by'    => 'Người sửa',



            ],
            'fieldSearch' => [ // danh sách các field sẽ tìm kiếm
                $this->table . '.name' => 'Tên',
            ],
            'button' => ['edit', 'delete'], // các button cho mỗi row hiển thị( xem danh sách button trong BackenModel)
        ];
        parent::__construct();
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

        return $query;
    }
    public function listItem($params = null, $options = null)
    {
        $this->_data['status'] = false;

        if ($options['task'] == "admin-index") {
            $this->checkall = true;
            $query = self::select($this->table . '.*', 'u.full_name AS created_by', 'u2.full_name AS updated_by')->withDepth()
                ->leftJoin(TABLE_USER . ' AS u',  'u.id', '=', $this->table . '.created_by')
                ->leftJoin(TABLE_HOTEL_POST_CATEGORY . ' AS p', 'p.id', '=', $this->table . '.parent_id')
                ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by');

            $query = self::adminQuery($query, $params);
            $sortBy = isset($params['sort']) && !empty($params['sort']) ? str_replace('-', '_', $params['sort']) : $this->table . '.' . $this->primaryKey;
            $orderBy = isset($params['order']) && !empty($params['order']) ? $params['order'] : 'DESC';

            $this->_data['items'] = $query->orderBy($sortBy, $orderBy)->paginate($params['item-per-page']);

            $this->_data['headTable'] = $this->headTable($this->_data['listField']);
            $this->_data['contentHtml'] = $this->contentHtml($params, $this->_data);
            $this->_data['status'] = true;
            // unset($this->_data['items']);
            unset($this->_data['headTable']);
        }
        return $this->_data;
    }
    public function saveItem($params = null, $options = null)
    {

        if ($options['task'] == 'add-item') {
            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');
            if (request()->hasFile('image')) {
                $params['image']  = FileService::file_upload($params, $params['image'], 'image');
            }

            if ($params['parent_id'] > 0) {
                $insertedId         = self::insertGetId($this->prepareParams($params), self::findOrFail($params['parent_id']));
            } else {
                $insertedId         = self::insertGetId($this->prepareParams($params));
            }

            PostCategoryModel::fixTree();
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }

        if ($options['task'] == 'edit-item') {

            if (request()->hasFile('image')) {
                $params['image']  = FileService::file_upload($params, $params['image'], 'image');
            }
            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            $this->where($this->primaryKey, $params[$this->primaryKey])
                ->update($this->prepareParams($params));
            PostCategoryModel::fixTree();
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
                $result['status']   = trim($result['status']);
            }
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
    public static function slbStatus($default = null, $params = [])
    {
        return '<select class="form-select mb-2" id="status" data-control="select2" name="status"
                        data-placeholder="Select an option" data-allow-clear="true">
                   ' . (!$default ? '<option value="" selected>Chọn trạng thái</option>' : '') . '
                    <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
                    <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
                </select>';
    }
    public static function createTreeTable($params, $nodes,)
    {

        $xhtml = '';
        $traverse = function ($categories, $prefix = '', $parent = '') use (&$traverse, $xhtml, $params) {

            foreach ($categories as $key => $category) {

                $btnAction   = \App\Helpers\Template::adminButtonAction($params, $params['model']['button'], $category['id']);
                $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'down', 'id' => $category['id']]) . '" title="Xuống" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-danger">
                                <i class="fa-sharp fa-solid fa-arrow-down"></i>
                            </a>
                            <a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'up', 'id' => $category['id']]) . '" title="Lên" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-success">
                                <i class="fa-sharp fa-solid fa-arrow-up"></i>
                            </a>';
                // $cls = $key % 2 == 0 ? 'pointer' : 'pointer';
                $cls = 'EEF1F3';
                if ($category->depth == 1) {
                    $cls = 'FFFFFF';
                }
                if ($category->depth == 2) {
                    $cls = 'FFFFFF';
                }
                if ($key == count($categories) - 1) {
                    $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'up', 'id' => $category['id']]) . '" title="Lên" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-success">
                                    <i class="fa-sharp fa-solid fa-arrow-up"></i>
                                </a>';
                }
                if ($key == 0) {
                    $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'down', 'id' => $category['id']]) . '" title="Xuống" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-danger">
                    <i class="mdi mdi-18px mdi-arrow-down-drop-circle"></i>
                    </a>';
                }
                if (count($category['children']) > 1) {
                    $parent = '<i class="fa-sharp fa-solid fa-caret-down text-dark"></i>';
                } else {
                    $parent = '';
                }
                // if (count($category['children']) > 1) {
                //     $parent = '<i class="fa-sharp fa-solid fa-caret-down text-dark"></i>';
                // } else {
                //     $parent = '';
                // }
                $xhtml .= '<tr style="background-color:#' . $cls . '">
                                <td class="text-left align-middle p-1"><strong>' . $prefix . $category->name . $parent . '</strong></td>
                                <td class="text-center align-middle p-1">' . $btnMove . '</td>
                                <td class="text-center align-middle p-1">' . \App\Helpers\Template::btnStatus($params, $category->id,  $category->status) . '</td>
                                <td class="text-left align-middle p-1">' . ($category->created_by ?? '---') . '</td>
                                <td class="text-left align-middle p-1">' . $category->created_at . '</td>
                                <td class="text-left align-middle p-1">' . ($category->updated_by ?? '---') . '</td>
                                <td class="text-left align-middle p-1">' . $category->updated_at . '</td>
                                <td class="text-center align-middle p-1">' . $btnAction . '</td>
                            </tr>';

                $xhtml .= $traverse($category['children'], $prefix . '<i class="fa-sharp fa-solid fa-minus text-primary"></i>', $parent);
            }
            return $xhtml;
        };

        return '<table id="table-list-' . $params['prefix'] . '-' . $params['controller'] . '" class="table table-bordered">' .
            '<thead class="bg-white">' .
            '<th class="text-left font-weight-bold">Danh mục</th>' .
            '<th class="text-center font-weight-bold" width="7%">Sắp sếp</th>' .
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
    private function saveImageS3($params, $options)
    {
        $params['bucket']       = 's3_' . $params['prefix'];
        if ($options['task'] == 'add-item') {
            $insertedId             = $params['inserted_id'];
            $folderPath             = $params['controller'] . '/images/' . $params['inserted_id'] . '/';
            $image                  = $params['image'];
            $imageName              = $params['slug'] . '.' . $image->extension();
            Storage::disk($params['bucket'])->put($folderPath . $imageName, file_get_contents($image));
            $params['image']        = $imageName;
            $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
            unset($params['bucket'], $params['inserted_id']);
            $this->where($this->primaryKey, $insertedId)
                ->update($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') {
            $oldImage               = $params[$this->primaryKey];
            $folderPath             = $params['controller'] . '/images/' . $oldImage . '/';
            if ($oldImage) {
                Storage::disk($params['bucket'])->delete($folderPath . $params['image_name']);
                Storage::disk($params['bucket'])->delete($folderPath . '/thumb1/'   . $params['image_name']);
            }
            $image                  = $params['image'];
            $imageName              = $params['slug'] . '.' . $image->extension();
            Storage::disk($params['bucket'])->put($folderPath . $imageName, file_get_contents($image));
            $params['image']        = $imageName;
            $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
            unset($params['bucket'], $params['inserted_id']);
            return $params;
        }
    }
    // public static function treeSelectCategory($selected_id = null)
    // {

    //     $xhtml = '';
    //     foreach ($categories as $category) {
    //         if ($categories instanceof Collection) {
    //             $selected = $selected_id && $selected_id->contains($category->id) == true ? 'selected' : '';
    //         } else {
    //             $selected = $selected_id && $selected_id == $category['id'] ? 'selected' : '';
    //         }
    //         $xhtml .= '<option ' . $selected . ' value="' . $category['id'] . '">' . str_repeat('--', $category['depth']) . $category['name'] . '</option>';
    //     }
    //     return $xhtml;
    // }
    public static function treeSelectCategory($selected_id = null, $current_id = null)
    {
        $categories = self::select('id', 'name', 'parent_id')->withDepth()->defaultOrder()->get();
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
}
