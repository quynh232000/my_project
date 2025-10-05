<?php

namespace App\Http\Controllers\Api\V1\Cms;

use App\Helpers\RouteHelper;
use App\Http\Controllers\Api\CmsController;
use App\Http\Requests\Api\V1\Cms\Permission\CreateRequest;
use App\Http\Requests\Api\V1\Cms\Permission\ShowRequest;
use App\Http\Requests\Api\V1\Cms\Permission\ToggleStatusRequest;
use App\Http\Requests\Api\V1\Cms\Permission\UpdateRequest;
use App\Models\Api\V1\Cms\PermissionMappingModel;
use App\Models\Api\V1\Cms\PermissionModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * @authenticated
 */
class PermissionController extends CmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PermissionModel();
    }
    public function index(Request $request)
    {
        try {
            $result = $this->model->listItem($this->_params, ['task' => 'list']);
            return $this->paginated('Lấy thông tin thành công!', $result->items(), 200, [
                'per_page'      => $result->perPage(),
                'current_page'  => $result->currentPage(),
                'total_page'    => $result->lastPage(),
                'total_item'    => $result->total(),
            ]);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    private function buildRouteTreeToList($routes) {
        $tree = [];

        foreach ($routes as $route) {
            $parts = explode('.', $route['route_name']); // ["api","v1","cms","user","update"]
            $parts = array_slice($parts, 3); // bỏ "api.v1" => ["cms","user","update"]

            $current = &$tree;

            foreach ($parts as $i => $part) {
                if ($i === count($parts) - 1) {
                    // node cuối: push vào mảng
                    $current[] = $route;
                } else {
                    if (!isset($current[$part])) {
                        $current[$part] = [];
                    }
                    $current = &$current[$part];
                }
            }
        }

        return $tree;
    }
    public function new(Request $request)
    {
        try {
            $allRoutes = RouteHelper::getRouteSettings(['api/v1/cms']);
            $existing                       = PermissionMappingModel::pluck('route_name')->toArray();

            $routes                         = $allRoutes->filter(fn($r) => !in_array($r['route_name'], $existing));
            $routes                         = $routes->reverse();

            return self::buildRouteTreeToList($routes->toArray());;
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function store(CreateRequest $request)
    {
        try {
            $result = $this->model->saveItem($this->_params, ['task' => 'add-item']);

            return $this->success('Tạp yêu cầu thành công!', $result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function update(UpdateRequest $request, $permission)
    {
        try {
            $result = $this->model->saveItem([...$this->_params, 'id' => $permission], ['task' => 'edit-item']);

            return $this->success('Tạp yêu cầu thành công!', $result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function show(ShowRequest $request, $permission)
    {
        try {
            $result =  $this->model->getItem([...$this->_params, 'id' => $permission], ['task' => 'detail']);

            return $this->success('Lấy thông tin chi tiết thành công!', $result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function toggleStatus(ToggleStatusRequest $request)
    {
        try {
            $this->model->saveItem([...$this->_params], ['task' => 'toggle-status']);

            return $this->success('Thực hiện yêu cầu thành công!');
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function destroy(Request $request,$permission)
    {
        $this->_params['id'] = $permission;
        $this->model->deleteItem($this->_params, ['task' => 'delete-item']);
        return $this->success('Thực hiện yêu cầu thành công!',$this->_params['id']);
    }
}
