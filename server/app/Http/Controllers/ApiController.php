<?php

namespace App\Http\Controllers;

use App\Traits\ApiRes;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      title="API Quin Admin",
 *      version="1.0.0"
 * ),
 */
abstract class ApiController extends Controller
{
    use ApiRes;
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
}
