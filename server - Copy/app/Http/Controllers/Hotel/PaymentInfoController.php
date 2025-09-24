<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\AdminController;
use App\Models\Hotel\PaymentInfoModel;
use Illuminate\Http\Request;

class PaymentInfoController extends AdminController
{
    public $model;
    public $backend_model;
    public $category;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PaymentInfoModel();
    }

    public function index(Request $request)
    {
        $this->_params["item-per-page"] = $this->getCookie('-item-per-page', 25);
        $this->_params['model'] = $this->model->listItem($this->_params, ['task' => "admin-index"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function show($id)
    {
        $this->_params['id']    = $id;
        $this->_params['item']  = $this->model->getItem($this->_params,['task' => 'get-item']);
        return response()->json(array('success' => true, 'html' => view($this->_viewAction, ['params' => $this->_params])->render()));
    }
    public function edit($id)
    {
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        $this->_params['item']   = $this->model->getItem($this->_params, ['task' => 'get-item']);
        $this->_params['status'] = $this->model->dataType;
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    
    public function update(Request $request)
    {   
        if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
            $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        }
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }
    public function choose(Request $request)
    {
        $response = $this->model->saveItem($this->_params, ['task' => 'choose']);
        return response()->json($response,200);
    }

    public function confirmChoose(Request $request)
    {
        $this->_params['url']       = route($this->_params['prefix'] . '.' . $this->_params['controller'] . '.choose');
        if(isset($this->_params['type']) && $this->_params['type'] == 'set-status'){
            $this->_params['item']  = $this->model->getItem($this->_params,['task' => 'get-item']);
        }
        return response()->json(array('success' => true, 'html' => view($this->_viewAction, ['params' => $this->_params])->render()));
    }
}
