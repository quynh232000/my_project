<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Admin\PermissionModel;
use App\Models\General\FileUploadModel;
use Illuminate\Http\Request;

class FileUploadController extends AdminController
{
    private $table = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new FileUploadModel();
    }
    public function index()
    {

        $this->_params['items']   =  $this->table->orderBy('id', 'desc')->paginate(20);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(Request $request, $id)
    {
        PermissionModel::where(['id' => $id])->update(['name' => $request->permission_name]);
        return redirect()->back()->with('success', ' Update successfully!');
    }

    public function store(Request $request)
    {

        return redirect()->back()->with('success', 'Permission mapped to route successfully.');
    }
    public function destroy($id)
    {
        $this->table->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Delete route successfully.');
    }
}
