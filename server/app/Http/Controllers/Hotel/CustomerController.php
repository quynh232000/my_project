<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Hotel\CustomerRequest;
use App\Models\Hotel\CustomerModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CustomerController extends AdminController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new CustomerModel();

    }


    public function index(Request $request)
    {
        $this->_params["item-per-page"]     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => "admin-index"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }

    public function create()
    {   
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(CustomerRequest $request)
    {
        $this->_params['ip'] =  $request->ip();
        return  $this->model->saveItem($this->_params, ['task' => 'add-item']);

    }
    public function edit($id)
    {
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        $this->_params['item']  = $this->model->getItem($this->_params, ['task' => 'get-item-info']);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(CustomerRequest $request)

    {
        if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
            $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        }
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }
    public function confirmDelete(Request $request)
    {
        $ids = $request->input('id');
        $ids = $ids ? (array)$ids : '';
        return response()->json([
            'success' => true,
            'html' => view('layouts.backend.inc.confirm-delete', [
                'ids' => $ids,
                'url' => route($this->_params['prefix'] . '.' . $this->_params['controller'] . '.destroy', $ids),
            ])->render(),
        ]);
    }
    public function destroy(Request $request)
    {
        $this->_params['id'] = $request->input('id');
        $this->model->deleteItem($this->_params, ['task' => 'delete-item']);
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }
}
