<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\Admin\PermissionModel;
use App\Models\Admin\RoleModel;
use App\Models\Admin\UserModel;
use App\Models\Admin\UserPermissionModel;
use App\Models\Admin\UserRoleModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends AdminController
{
    private $table = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new UserModel();
    }
    public function index(Request $req)
    {
        $query = UserModel::with('roles');

        if($req->search ?? false){
            $query->where(function($q)use($req){
                $q->where('email','LIKE', '%'.$req->search.'%')
                ->orWhere('full_name','LIKE', '%'.$req->search.'%');
            });
        }

        $this->_params['items'] = $query->orderBy('id', 'desc')->paginate(20);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(UpdateRequest $request, $id)
    {
        $user = $this->table->find($id);
        // Cập nhật thông tin người dùng
        $user->update([
            'full_name' => $request->full_name,
            'username'  => explode('@', $request->email)[0],
            'email'     => $request->email,
            'phone'     => $request->phone ?? '',
            'avatar'    => $avatar ?? $user->avatar, // giữ lại avatar nếu không thay đổi
        ]);

        if (!empty($request->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Cập nhật vai trò
        if ($request->role ?? false) {
            // Xoá role cũ
            UserRoleModel::where('user_id', $user->id)->delete();

            // Thêm role mới
            $dataRoleInsert = [];
            foreach ($request->role as $role_id) {
                $dataRoleInsert[] = [
                    'user_id' => $user->id,
                    'role_id' => $role_id,
                ];
            }
            UserRoleModel::insert($dataRoleInsert);
        }

        // Cập nhật quyền
        if ($request->permission ?? false) {
            // Xoá permission cũ
            UserPermissionModel::where('user_id', $user->id)->delete();

            // Thêm permission mới
            $dataPermissionInsert = [];
            foreach ($request->permission as $permission_id) {
                $dataPermissionInsert[] = [
                    'user_id'       => $user->id,
                    'permission_id' => $permission_id,
                ];
            }
            UserPermissionModel::insert($dataPermissionInsert);
        }
        return redirect()->back()->with('success', 'Update user successfully!');;
    }
    public function edit($id)
    {
        $this->_params['roles']         = RoleModel::orderByDesc('id')->get();
        $this->_params['permissions']   = PermissionModel::select('id', 'name', 'resource_type', 'uri')->orderBy('created_at', 'desc')->get()->groupBy('resource_type');
        $this->_params['item']          = $this->table->find($id);
        $this->_params['role_ids']           = $this->_params['item']->roles->pluck('id')->toArray();
        $this->_params['permission_ids']            = $this->_params['item']->permissions->pluck('id')->toArray();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create()
    {

        $this->_params['roles']         = RoleModel::orderByDesc('id')->get();
        $this->_params['permissions']   = PermissionModel::select('id', 'name', 'resource_type', 'uri')->orderBy('created_at', 'desc')->get()->groupBy('resource_type');
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(StoreRequest $request)
    {
        $list_avatars       = [
            'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
            'https://img.freepik.com/free-psd/3d-illustration-bald-person-with-glasses_23-2149436184.jpg',
            'https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436191.jpg',
            'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436178.jpg'
        ];
        $avatar             = $list_avatars[rand(0, count($list_avatars) - 1)];
        if ($request->hasFile('avatar')) {
            $FileService    = new FileService();
            $avatar         = $FileService->uploadFile($request->avatar, 'user.avatar', auth()->id())['url'] ?? '';
        }
        $user = UserModel::create([
            'uuid'          => Str::uuid(),
            'full_name'     => $request->full_name,
            'phone'         => $request->phone ?? '',
            'username'      => explode('@', $request->email)[0],
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'avatar'        => $avatar
        ]);

        if ($request->role ?? false) {
            $dataRoleInsert         = [];
            foreach ($request->role as $role_id) {
                $dataRoleInsert[]   = [
                    'user_id'   => $user->id,
                    'role_id'   => $role_id
                ];
            }
            UserRoleModel::insert($dataRoleInsert);
        }
        if ($request->permission ?? false) {
            $dataPermissionInsert         = [];
            foreach ($request->permission as $permission_id) {
                $dataPermissionInsert[]   = [
                    'user_id'           => $user->id,
                    'permission_id'     => $permission_id
                ];
            }
            UserPermissionModel::insert($dataPermissionInsert);
        }

        return redirect()->back()->with('success', 'Create user successfully!');
    }
    public function show($id)
    {
        $this->_params = UserModel::find($id);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
}
