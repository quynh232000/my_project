<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Kalnoy\Nestedset\NodeTrait;
class ServiceModel extends AdminModel
{
    use NodeTrait;
    public $hotel;
    public $data = [
        'type' => [
            'hotel'         => 'Khách sạn',
            'room'          => 'Phòng',
        ]
    ];
    public $crudNotAccepted = ['image_id'];
    public function __construct($attributes = [])
    {
        $this->table        = TABLE_HOTEL_SERVICE;
        $this->attributes   = $attributes;
        $this->_data        =  [
            'listField'           => [ // liệt kê các field sẽ hiển thị ở trang danh sách theo key - value được khai báo
                $this->table . '.id'            => 'id',
                $this->table . '.name'          => 'Dịch vụ',
                'p.name AS parent_name'         => 'Dịch vụ & tiện ích cha',
                'u.full_name AS created_by'     => 'Người tạo',
                $this->table . '.created_at'    => 'Ngày tạo',
                'u2.full_name AS updated_by'    => 'Người sửa',
                $this->table . '.updated_at'    => 'Ngày sửa',
            ],
            'fieldSearch'           => [ // danh sách các field sẽ tìm kiếm
                $this->table . '.name'          => 'Tiêu đề',
                // $this->table . '.slug'          => 'Slug',
            ],
            'button'                => ['edit', 'delete'] // các button cho mỗi row hiển thị( xem danh sách button trong BackenModel)
        ];
        parent::__construct();
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
        if (isset($params['update_name']) && $params['update_name'] !== "all") {
            $query->where('u2.full_name', 'LIKE', '%' . $params['update_name'] . '%');
        }
        if (isset($params['name']) && $params['name'] !== "all") {
            $query->where($this->table . '.name', 'LIKE', '%' . $params['name'] . '%');
        }
        if (isset($params['type']) && $params['type'] !== "") {
            $query->where($this->table . '.type', $params['type']);
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

            $query = self::select($this->table . '.*', 'u.full_name AS created_by', 'u2.full_name AS updated_by')->withDepth();

            $query = $query->leftJoin(TABLE_USER . ' AS u', 'u.id', '=', $this->table . '.created_by')
                           ->leftJoin(TABLE_USER . ' AS u2', 'u2.id', '=', $this->table . '.updated_by');

            $query = self::adminQuery($query, $params);

            $this->_data['items']   = $query->paginate($params['item-per-page']);
        }
        return $this->_data;
    }
    public function saveItem($params = null, $options = null)
    {

        if ($options['task'] == 'add-item') { //thêm mới

            $params['created_by']   = Auth::user()->id;
            $params['created_at']   = date('Y-m-d H:i:s');
            if ($params['parent_id'] > 0) {
                $insertedId         = self::insertGetId($this->prepareParams($params), self::findOrFail($params['parent_id']));
            } else {
                $insertedId         = self::insertGetId($this->prepareParams($params));
            }
            if (request()->hasFile('image')) {
                $params['inserted_id']  = $insertedId;
                $this->saveImageS3($params, $options);
            }
            ServiceModel::fixTree();
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }

        if ($options['task'] == 'edit-item') { //cập nhật
            $params['updated_by']       = Auth::user()->id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            if (request()->hasFile('image')) {
                $params['inserted_id']  = $params[$this->primaryKey];
                $params                 = $this->saveImageS3($params, $options);
            }

            $this->where($this->primaryKey, $params[$this->primaryKey])
                ->update(
                    $this->prepareParams($params)
                );
            ServiceModel::fixTree();
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

                $result          = $result->toArray();
                $params['item']  = $result;
                if ($result['image'] != null ) {

                    $result['image'] = $this->getImageUrlS3($result['image'], $params);
                }
            }
        }
        if ($options['task'] == "get-service") {

            $result = self::select($this->table . '.*')
                            ->withDepth()->defaultOrder()->get();
        }
        if ($options['task'] == 'get-room-service') {

            $result = null;
            //CAN FIX SHOW PARENT CHILD
            $result = self::select($this->table . '.*')
                            ->where(['parent_id' => null, 'type' => 'room'])
                            ->with(['children' => function( $query ){
                                $query->where($this->table . '.type' , 'room');
                            }])->defaultOrder()->get();
        }
        if ($options['task'] == 'get-hotel-service') {
            $result = self::select($this->table . '.*')
                            ->where(['parent_id' => null, 'type' => 'hotel'])
                            ->with(['children' => function( $query ){
                                $query->where($this->table . '.type' , 'hotel');
                            }])->defaultOrder()->get()->toArray();
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
    public static function createTreeTable($params, $nodes,)
    {

        $xhtml = '';
        $traverse = function ($services, $prefix = '', $parent = '') use (&$traverse, $xhtml, $params) {

            foreach ($services as $key => $service) {

                $btnAction   = \App\Helpers\Template::adminButtonAction($params, $params['model']['button'], $service['id']);
                $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'down', 'id' => $service['id']]) . '" title="Xuống" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-danger">
                                <i class="fa-sharp fa-solid fa-arrow-down"></i>
                            </a>
                            <a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'up', 'id' => $service['id']]) . '" title="Lên" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-success">
                                <i class="fa-sharp fa-solid fa-arrow-up"></i>
                            </a>';
                // $cls = $key % 2 == 0 ? 'pointer' : 'pointer';
                $cls = 'EEF1F3';
                if ($service->depth == 1) {
                    $cls = 'FFFFFF';
                }
                if ($service->depth == 2) {
                    $cls = 'FFFFFF';
                }
                if ($key == count($services) - 1) {
                    $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'up', 'id' => $service['id']]) . '" title="Lên" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-success">
                                    <i class="fa-sharp fa-solid fa-arrow-up"></i>
                                </a>';
                }
                if ($key == 0) {
                    $btnMove = '<a href="' . route($params['prefix'] . '.' . $params['controller'] . '.move', ['act' => 'down', 'id' => $service['id']]) . '" title="Xuống" class="' . $params['prefix'] . '-' . $params['controller'] . '-move' . ' text-danger">
                    <i class="mdi mdi-18px mdi-arrow-down-drop-circle"></i>
                    </a>';
                }
                if (count($service['children']) > 1) {
                    $parent = '<i class="fa-sharp fa-solid fa-caret-down text-dark"></i>';
                } else {
                    $parent = '';
                }
                // if (count($service['children']) > 1) {
                //     $parent = '<i class="fa-sharp fa-solid fa-caret-down text-dark"></i>';
                // } else {
                //     $parent = '';
                // }

                $type = $service->type == 'room' ? 'Phòng' : 'Khách sạn';

                $xhtml .= '<tr style="background-color:#' . $cls . '">
                                <td class="text-left align-middle p-1"><strong>' . $prefix . $service->name . $parent . '</strong></td>
                                <td class="text-center align-middle p-1">' . $btnMove . '</td>
                                <td class="text-left align-middle p-1">' . $type . '</td>
                                <td class="text-center align-middle p-1">' . \App\Helpers\Template::btnStatus($params, $service->id,  $service->status) . '</td>
                                <td class="text-left align-middle p-1">' . ($service->created_by ?? '---') . '</td>
                                <td class="text-left align-middle p-1">' . $service->created_at . '</td>
                                <td class="text-left align-middle p-1">' . ($service->updated_by ?? '---') . '</td>
                                <td class="text-left align-middle p-1">' . $service->updated_at . '</td>
                                <td class="text-center align-middle p-1">' . $btnAction . '</td>
                            </tr>';

                $xhtml .= $traverse($service['children'], $prefix . '<i class="fa-sharp fa-solid fa-minus text-primary"></i>', $parent);
            }
            return $xhtml;
        };

        return '<table id="table-list-' . $params['prefix'] . '-' . $params['controller'] . '" class="table table-bordered">' .
            '<thead class="bg-white">' .
            '<th class="text-left font-weight-bold">Tiện ích & dịch vụ</th>' .
            '<th class="text-center font-weight-bold" width="7%">Sắp sếp</th>' .
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
    public static function slbStatus($default = 'inactive',$params = [])
    {
        $showDefaultOption = isset($params['action']) && $params['action'] == 'index';
        $default = isset($params['item']['status']) ? $params['item']['status'] : '';
        return '<select id="status" name="status" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                   ' . ($showDefaultOption ? '<option value="" selected>Chọn trạng thái</option>' : '') . '

        <option value="inactive" ' . ($default == "inactive" ? "selected" : "") . '>Ẩn</option>
            <option value="active" ' . ($default == "active" ? "selected" : "") . '>Hiện</option>
        </select>';
    }
    public function getImageUrlS3($fileName, $params)
    {
        $filePath = $params['controller'] .'/images/'. $params['item']['id'] .'/'. $fileName;
        return Storage::disk('s3_' . $params['prefix'])->url($params['prefix'] .'/'. $filePath);
    }
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
    private function saveImageS3($params, $options)
    {
        $params['bucket']       = 's3_' . $params['prefix'];
        if ($options['task'] == 'add-item') {
            $insertedId             = $params['inserted_id'];
            $folderPath             =  $params['controller'] . '/images/' . $params['inserted_id'] . '/';
            $image                  = $params['image'];
            $imageName              = $params['slug'] . '.' . $image->extension();
            Storage::disk( $params['bucket'])->put($folderPath . $imageName, file_get_contents($image));
            $params['image']        = $imageName;
            $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
            unset($params['bucket'], $params['inserted_id']);
            $this->where($this->primaryKey, $insertedId)
                ->update($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') {
            $oldImage               = $params['image_id'];
            $folderPath             = $params['controller'] .'/images/'. $oldImage . '/';
            if ($oldImage) {
                Storage::disk(  $params['bucket'])->delete($folderPath . $oldImage);
                Storage::disk(  $params['bucket'])->delete($folderPath . '/thumb1/'   . $oldImage);
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
    public static function treeSelectCategory($categories, $selected_id = null)
    {
        $xhtml = '';
        foreach ($categories as $category) {
            $selected = $selected_id && $selected_id == $category['id'] ? 'selected' : '';
            $xhtml .= '<option ' . $selected . ' value="' . $category['id'] . '">' . str_repeat('--', $category['depth']) . $category['name'] . '</option>';
        }
        return $xhtml;
    }
}
