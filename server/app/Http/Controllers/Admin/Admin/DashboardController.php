<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Admin\PermissionModel;
use App\Models\General\FileUploadModel;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    private $table = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new FileUploadModel();
    }
    public function dashboard(){
        return view('dashboard');
    }
}
