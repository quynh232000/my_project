<?php

namespace App\Http\Controllers\Admin\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\Admin\OrganizationRequest;
use App\Models\Admin\OrganizationModel;
use App\Models\Admin\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class OrganizationController extends AdminController
{
    protected $table = null ;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new OrganizationModel();

    }
    public function index() {
        $this->_params['data'] = $this->table->orderBy('created_at','desc')->paginate(20);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(OrganizationRequest $request) {
        $this->table->insert([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'description'   => $request->description ?? '',
            'status'        => 'active'
        ]);
        return redirect()->back()->with('success','Create successfully!');
    }
    public function update() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function edit() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function show($id) {
        $this->_params = UserModel::find($id);
        return view($this->_viewAction, ['params' => $this->_params]);
    }

}
