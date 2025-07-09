<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hotel\RoomTypeRequest;
use App\Models\Hotel\RoomTypeModel;
use App\Models\Hotel\ServiceModel;
use Illuminate\Http\Request;

class RoomController extends AdminController
{
    public $model;
    public $data;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new RoomTypeModel();
    }
    public function index(Request $request)
    {
        $this->_params["item-per-page"]   = $this->getCookie('-item-per-page', 25);
        $this->_params['model']           = $this->model->listItem($this->_params, ['task' => "admin-index"]);
        
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create()
    {   
        $this->_params['tag_image']        = $this->model->data['tag_image'];
        $this->_params['room_type']        = $this->model->data['room_type'];
        $this->_params['bed_type']         = $this->model->data['bed_type'];
        $this->_params['room_direction']   = $this->model->data['room_direction'];
        $this->_params['hotel']            = $this->model->getItem($this->_params, ['task' => "get-hotel"]);
        $this->_params['service']          = $this->model->getItem($this->_params,['task' => 'get-room-service']);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(RoomTypeRequest $request)
    {
        $this->model->saveItem($this->_params, ['task' => 'add-item']);
        return response()->json(array('success' => true, 'message' => 'Thêm thành công'));
    }
    public function edit($id)
    {
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        $this->_params['item']              = $this->model->getItem($this->_params, ['task' => 'get-item-info']);
        $this->_params['tag_image']         = $this->model->data['tag_image'];
        $this->_params['room_type']         = $this->model->data['room_type'];
        $this->_params['bed_type']          = $this->model->data['bed_type'];
        $this->_params['room_direction']    = $this->model->data['room_direction'];
        $this->_params['hotel']             = $this->model->getItem($this->_params, ['task' => "get-hotel"]);
        $this->_params['service']           = $this->model->getItem($this->_params,['task' => 'get-room-service']);
        
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(RoomTypeRequest $request)
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
            'html'    => view('layouts.backend.inc.confirm-delete', [
                'ids' => $ids,
                'url' => route($this->_params['prefix'] . '.' . $this->_params['controller'] . '.destroy',$ids),
            ])->render(),
        ]);
    }
    public function destroy(Request $request)
    {
        $this->_params['id'] = $request->input('id');       
        $this->model->deleteItem($this->_params, ['task' => 'delete-item']);   
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }    
    public function getInfo(){
        
        $this->_params['data']      = $this->model->getItem($this->_params,['task' => 'get-hotel-service']);
        $this->_params['abumn']     = $this->model->getItem($this->_params,['task'=>'get-abumn']); 
        return response()->json(array('success' => true, 'datas' => $this->_params));
    }
    public function getAbumnImage(){
        
        return $this->model->getItem($this->_params,['task'=>'get-img-by-abumn']); 
    }
    
}
