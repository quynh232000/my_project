<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class AdminController extends Controller
{
    protected $_params      = [];
    protected $_viewAction  = '';
    public function __construct(Request $request)
    {
        $requestAction                  = $request->route()->getAction();

        $alias                          = explode('.', $requestAction['as']);
        $this->_params['prefix']        = isset($alias[0]) ? $alias[0] : 'admin';
        $this->_params['controller']    = isset($alias[1]) ? $alias[1] : 'index';
        $this->_params['action']        = isset($alias[2]) ? $alias[2] : 'index';
        $this->_params['as']            = $requestAction['as'];

        $this->_params = array_merge($this->_params, $request->all());

        $this->_viewAction              = $this->_params['prefix'] . '.' . $this->_params['controller'] . '.' . $this->_params['action'];
    }
    protected function getCookie($key, $defaultValue)
    {
        $name = $this->_params['prefix']  . '-' .  $this->_params['controller']   . '-' .  $this->_params['action'] . $key;
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $defaultValue;
    }

}
