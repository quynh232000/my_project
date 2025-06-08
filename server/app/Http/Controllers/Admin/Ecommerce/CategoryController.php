<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;


class CategoryController extends AdminController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function login() {
        return view($this->_viewAction, ['params' => $this->_params]);
    }

}
