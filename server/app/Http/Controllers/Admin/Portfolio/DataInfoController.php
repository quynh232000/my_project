<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\AdminController;
use App\Models\Admin\PermissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class DataInfoController extends AdminController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function index()
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
        $query                          =    PermissionModel::query();
        if ($this->_params['search'] ?? false) {
            $query->where('name', 'LIKE', '%' . $this->_params['search'] . '%');
        }
        $this->_params['permissions']   =  $query->orderBy('created_at', 'desc')->paginate(20);

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
        PermissionModel::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Delete route successfully.');
    }
}
