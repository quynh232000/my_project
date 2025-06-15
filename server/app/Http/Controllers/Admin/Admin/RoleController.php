<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Admin\PermissionModel;
use App\Models\Admin\RoleModel;
use App\Models\Admin\RolePermissionModel;
use App\Models\Admin\UserModel;
use App\Models\Admin\UserRoleModel;
use Illuminate\Http\Request;

class RoleController extends AdminController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function index()
    {

        $this->_params['roles'] = RoleModel::with('permissions')->orderByDesc('id')->paginate(20);

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(Request $request, $id)
    {
        $item               = RoleModel::findOrFail($id);
        $item->name         = $request->name;
        $item->description  = $request->description;
        $item->save();

        // check role permission
        RolePermissionModel::whereNotIn('permission_id', $request->permissions ?? [])->where('role_id', $id)->delete();


        $dataInsert         = [];
        foreach ($request->permission ?? [] as $key => $value) {
            $dataInsert[]   = [
                'permission_id' => $value,
                'role_id'       => $id
            ];
        }
        if (count($dataInsert) > 0) {
            RolePermissionModel::upsert($dataInsert, ['role_id', 'permission_id'], []);
        }
        return redirect()->back()->with('success', 'Update successfully!');
    }
    public function create()
    {

        $this->_params['items'] = PermissionModel::select('id', 'name', 'resource_type', 'uri')->orderBy('created_at', 'desc')->get()->groupBy('resource_type');
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function edit($id)
    {
        $this->_params['items']     = PermissionModel::select('id', 'name', 'resource_type', 'uri')->orderBy('created_at', 'desc')->get()->groupBy('resource_type');
        $this->_params['item']      = RoleModel::with('permissions')->find($id);
        $this->_params['item']['permissions']   = $this->_params['item']->permissions->pluck('id')->all();

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {
        $role               = RoleModel::create(['name' => $request->name,'description' => $request->description ?? '']);

        $dataInsert         = [];
        foreach ($request->permission ?? [] as $key => $value) {
            $dataInsert[]   = [
                'permission_id' => $value,
                'role_id'       => $role->id
            ];
        }
        if (count($dataInsert) > 0) {
            RolePermissionModel::insert($dataInsert);
        }
        return redirect()->back()->with('success', 'Create successfully!');
    }
    public function show($id)
    {
        $this->_params['item'] = RoleModel::with('permissions','user_roles.user')->find($id);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function destroy($id)
    {
        UserRoleModel::where('id',$id)->delete();
        return redirect()->back()->with('success',' Delete User Role successfully!');
    }


}
