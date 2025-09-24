<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\Album\EditRequest;
use App\Http\Requests\Api\V1\Hms\Album\StoreRequest;
use App\Models\Api\V1\Hms\AlbumModel;
use Illuminate\Http\Request;

class AlbumController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new AlbumModel();
    }
    public function index(Request $request)
    {
        $response = $this->model->listItem($this->_params, ['task' => 'list-item']);
        return response()->json($response);
    }
    public function list(Request $request)
    {
        try {
            $result = $this->model->listItem($this->_params, ['task' => 'list']);

            return $this->success('Lấy thông tin thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function store(StoreRequest $request)
    {
        $response = $this->model->saveItem($this->_params, ['task' => 'add-item']);
        return $this->success($response['message'],$response['data'] ?? null);
    }
    public function edit(EditRequest $request)
    {
        try{
            $response = $this->model->saveItem($this->_params, ['task' => 'edit-item']);
            return $this->success($response['message'], $response['data'] ?? null);
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
        
    }
    public function delete()
    {
        try{
            $this->model->deleteItem($this->_params, ['task' => 'delete']);
            return $this->success('Thực hiện yêu cầu thành công');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
        
    }
}
