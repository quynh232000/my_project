<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;


class UserController extends AdminController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function login() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function register() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function reset_password() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function new_password() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function two_factor() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }
}
