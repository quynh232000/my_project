<?php

namespace App\Http\Controllers\Admin\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;


class GeneralController extends AdminController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function index() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function edit() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }

}
