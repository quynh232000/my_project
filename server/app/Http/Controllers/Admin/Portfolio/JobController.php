<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\AdminController;
use App\Models\Portfolio\JobModel;
use Illuminate\Http\Request;

class JobController extends AdminController
{
    public $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new JobModel();
    }

    public function index(Request $request)
    {
        $this->_params["item-per-page"] = $this->getCookie('-item-per-page', 25);
        $this->_params['model']         = $this->model->listItem($this->_params, ['task' => "admin-index"]);

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create()
    {

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {

        $this->model->saveItem($this->_params, ['task' => 'add-item']);
        return response()->json(array('success' => true, 'message' => 'Thêm thành công'));
    }
    public function edit($id)
    {

        $this->_params[$this->model->columnPrimaryKey()] = $id;
        $this->_params['item']                           = $this->model->getItem($this->_params, ['task'    => 'get-item-info']);

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(Request $request)
    {
        if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
            $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        }
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }
    public function show($id)
    {
        $this->_params['id']    = $id;
        $this->_params['item']  = $this->model->getItem($this->_params, ['task' => 'get-item-info']);

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function status($status, $id)
    {
        $this->_params['status']    = $status;
        $this->_params['id']        = $id;
        $this->model->saveItem($this->_params, ['task' => 'change-status']);
        return redirect()->route($this->_params['prefix'] . '.' . $this->_params['controller'] . '.index')->with('notify', 'Cập nhật trạng thái thành công!');
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
}
