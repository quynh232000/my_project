<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Hotel\HotelRequest;
use App\Models\Hotel\NearbyLocationModel;
use Illuminate\Http\Request;

class NearbyLocationController extends AdminController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new NearbyLocationModel();
    }
    public function index(Request $request)
    {
        $this->_params["item-per-page"]     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => "admin-index"]);
         return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create()
    {
        // $this->_params['info']    = $this->model->getItem($this->_params, ['task' => 'get-info']);
        // $this->_params['data']    = $this->model->getListService();
        return view($this->_viewAction,['params' => $this->_params]);
    }
    public function store(HotelRequest $request)
    {
       return  $this->model->saveItem($this->_params, ['task' => 'add-item']);
    }
    public function edit($id)
    {
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        $this->_params['info']                           = $this->model->getItem($this->_params, ['task' => 'get-info']);
        $this->_params['item']                           = $this->model->getItem($this->_params, ['task' => 'get-item-info']);
        $this->_params['data']                           = $this->model->getListService();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(HotelRequest $request,$id)
    {
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
            $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        }
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
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
        $ids = $request->input('id');
        $ids = $ids ? (array)$ids : '';
        return response()->json([
            'success' => true,
            'html'    => view('layouts.backend.inc.confirm-delete', [
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
    public function infoAddress(Request $request){
        $this->_params['id']   = $request->input('id');
        $this->_params['type'] = $request->input('type');
        $result                = $this->model->getInfoAddress($this->_params);
        return response()->json( ['status'=>true,'message'=>'Success','data'=>$result]);
    }
   
}
