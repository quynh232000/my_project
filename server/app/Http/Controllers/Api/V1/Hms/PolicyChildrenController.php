<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\PolicyChildren\DestroyRequest;
use App\Http\Requests\Api\V1\Hms\PolicyChildren\UpdateRequest;
use App\Models\Api\V1\Hms\PolicyChildrenModel;
use Illuminate\Http\Request;


class PolicyChildrenController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PolicyChildrenModel();
    }
    public function index(Request $request)
    {
        try {
            
            $result = $this->model->listItem($this->_params,['task' => 'list-item']);

            return $this->success('Lấy danh sách thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function store(UpdateRequest $request)
    {
        try {
            $this->model->saveItem($this->_params,['task' => 'edit-item']);
            
            return $this->success('Cập nhật thành công!');
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function destroy(DestroyRequest $request,$policy_child)
    {
        try {
            $this->model->deleteItem($policy_child,['task' => 'delete-item']);
            
            return $this->success('Thực hiện yêu cầu thành công!');
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
   
}
