<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Hotel\AttributeRequest;
use App\Models\Hotel\AttributeModel;
use Illuminate\Http\Request;

class AttributeController extends AdminController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new AttributeModel();
    }


    public function index(Request $request)
    {
        $this->_params["item-per-page"]     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => "admin-index"]);
        $this->_params['type']              = $this->model->listItem($this->_params, ['task' => "list-type"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function show($id)
    {
        $this->_params['id']            = $id;
        $this->_params['item']          = $this->model->getItem($this->_params, ['task' => 'get-item-info']);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function edit($id)
    {
        $parentCategories = $this->model->listItem($this->_params,['task' => 'list']);
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        $this->_params['item']              = $this->model->getItem($this->_params, ['task' => 'get-item-info']);
        return view($this->_viewAction, ['params' => $this->_params,  'parentCategories' => $parentCategories]);
    }
    public function update(AttributeRequest $request)
    {
        if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
            $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        }
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }
    public function create()
    {
        $parentCategories = $this->model->listItem($this->_params,['task' => 'list']);
        return view($this->_viewAction, [
            'params' => $this->_params,
            'parentCategories' => $parentCategories
        ]);
    }

    public function status($status, $id)
    {
        $this->_params['status']    = $status;
        $this->_params['id']        = $id;
        $this->model->saveItem($this->_params, ['task' => 'change-status']);
        return redirect()->route($this->_params['prefix'] . '.' . $this->_params['controller'] . '.index')->with('notify', 'Cập nhật trạng thái thành công!');
    }
    public function store(AttributeRequest $request)
    {
        $this->model->saveItem($this->_params, ['task' => 'add-item']);
        return response()->json(array('success' => true, 'message' => 'Thêm thành công'));
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
    public function move($act,$id){
        $item = AttributeModel::findOrFail($id);
        $item->$act();
        return redirect()->back()->with('success','Change successfully!');
    }
}
