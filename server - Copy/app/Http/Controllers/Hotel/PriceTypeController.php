<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\PriceTypeRequest;
use App\Models\Hotel\PriceTypeModel;
use Illuminate\Http\Request;

class PriceTypeController extends AdminController
{
    public $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PriceTypeModel();
    }
    public function index(Request $request)
    {
        $this->_params['item-per-page']     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => 'admin-index']);
        $this->_params['hotel']             = $this->model->getItem($this->_params, ['task' => "get-hotel"]);

        //$this->_params['priceType']         = $this->model->getItem($this->_params, ['task' => "get-all-price-type"]);
        //$this->_params['roomType']          = $this->model->getItem($this->_params, ['task' => "get-all-room-type"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create()
    {
        $this->_params['hotel']             = $this->model->getItem($this->_params, ['task' => "get-hotel"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function getInfo(){
        $this->_params['roomType']          = $this->model->getItem($this->_params, ['task' => "get-room-type"]);
        return $this->_params;
    }
    public function store(PriceTypeRequest $request)
    {
        $this->model->saveItem($this->_params, ['task' => 'add-item']);
        return response()->json(array('success' => true, 'message' => 'Thêm thành công'));
    }
    public function edit($id)
    {
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        $this->_params['item']              = $this->model->getItem($this->_params, ['task' => 'get-item-info']);
        $this->_params['hotel']             = $this->model->getItem($this->_params, ['task' => "get-hotel"]);
        $this->_params['hotel_id']          = $this->_params['item']['hotel_id'];
        $this->_params['roomType']          = $this->model->getItem($this->_params, ['task' => "get-room-type"]);

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(PriceTypeRequest $request)
    {
        if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
            $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        }
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }
    public function confirmDelete(Request $request)
    {
         $this->_params['id'] = $request->input('id');
        $this->model->deleteItem($this->_params, ['task' => 'delete-item']);
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }
    public function destroy(Request $request)
    {
        $this->_params['id'] = $request->input('id');
        $this->model->deleteItem($this->_params, ['task' => 'delete-item']);
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }
    public function status($status, $id)
    {
        $this->_params['status']    = $status;
        $this->_params['id']        = $id;
        $this->model->saveItem($this->_params, ['task' => 'change-status']);

        return redirect()->route($this->_params['prefix'] . '.' . $this->_params['controller'] . '.index')->with('notify', 'Cập nhật trạng thái thành công!');
    }
}
