<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Admin\PermissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PermissionController extends AdminController
{
    private $model = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PermissionModel();
    }
    public function index()
    {
        // return $this->model->all();
        $this->_params["item-per-page"]     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => "admin-index"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function new()
    {
        $allRoutes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri'       => $route->uri(),
                'name'      => $route->getName(),
                'method'    => implode('|', $route->methods()),
                'action'    => $route->getActionName(),
            ];
        })->filter(fn($r) => $r['name'] && !str_starts_with($r['uri'], '_') && !str_contains($r['uri'], 'telescope'));

        $existing                       = DB::table('route_permission_mappings')->pluck('route_name')->toArray();

        $routes                         = $allRoutes->filter(fn($r) => !in_array($r['name'], $existing));
        $routes                         = $routes->reverse();
        //         return $routes;
        // dd($routes);

        return view($this->_viewAction, ['params' => $this->_params, 'routes' => $routes]);
    }
    public function update(Request $request, $id)
    {
        PermissionModel::where(['id' => $id])->update(['name' => $request->permission_name]);
        return redirect()->back()->with('success', ' Update successfully!');
    }
    public function edit($id)
    {
        $this->_params['item'] = PermissionModel::findOrFail($id);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'route_name'        => 'required|string',
            'permission_name'   => 'required|string',
        ]);

        $permission = PermissionModel::firstOrCreate([
            'name'          => $request->permission_name,
            'route_name'    => $request->route_name,
            'resource_type' => ucfirst(Str::before($request->route_name, '.')),
            'uri'           => $request->uri,
            'method'        => $request->input('method'),

        ]);

        DB::table('route_permission_mappings')->insert([
            'route_name'        => $request->route_name,
            'permission_name'   => $permission->name,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->back()->with('success', 'Permission mapped to route successfully.');
    }
    public function destroy($id)
    {
        $item = PermissionModel::find($id);
        DB::table('route_permission_mappings')->where('route_name', $item->route_name)->delete();
        $item->delete();
        return redirect()->back()->with('success', 'Delete route successfully.');
    }
    public function bulkStore(Request $request)
    {
        $routes = $request->input('routes', []);

        foreach ($routes as $routeName => $data) {
            // Bỏ qua nếu không được chọn hoặc thiếu dữ liệu bắt buộc
            if (empty($data['selected']) || empty($data['route_name']) || empty($data['permission_name'])) {
                continue;
            }

            // Validate nhẹ trong vòng lặp
            $data['route_name'] = trim($data['route_name']);
            $data['permission_name'] = trim($data['permission_name']);

            // Tạo hoặc lấy lại permission
            $permission = PermissionModel::firstOrCreate([
                'name'          => $data['permission_name'],
            ], [
                'route_name'    => $data['route_name'],
                'resource_type' => ucfirst(Str::before($data['route_name'], '.')),
                'uri'           => $data['uri'] ?? '',
                'method'        => $data['method'] ?? '',
            ]);

            // Chèn mapping nếu chưa có
            DB::table('route_permission_mappings')->insertOrIgnore([
                'route_name'        => $data['route_name'],
                'permission_name'   => $permission->name,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm các route được chọn!');
    }
}
