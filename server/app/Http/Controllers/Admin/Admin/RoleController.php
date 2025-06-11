<?php

namespace App\Http\Controllers\Admin\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;


class RoleController extends AdminController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function index() {
        $this->_params['roles'] = config('custom_routes');
        // dd($this->_params['roles']);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function edit() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store() {

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function show() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }

}
