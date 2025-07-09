<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\PolicyCancellation\DestroyRequest;
use App\Http\Requests\Api\V1\Hms\PolicyCancellation\ShowRequest;
use App\Http\Requests\Api\V1\Hms\PolicyCancellation\UpdateRequest;
use App\Models\Api\V1\Hms\PolicyCancellationModel;
use Illuminate\Http\Request;


class PolicyCancellationController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PolicyCancellationModel();
    }
    public function index(Request $request)
    {
        try {
            if(isset($request->type)){
                $result = $this->model->listItem($this->_params,['task' => 'list_not_global']);
            }else{
                $result = $this->model->listItem($this->_params,['task' => 'list-item']);
            }

            return $this->success('Lấy danh sách thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function store(UpdateRequest $request)
    {
        try {
           $result = $this->model->saveItem($this->_params,['task' => 'edit-item']);
            
            return $this->success('Cập nhật thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function destroy(DestroyRequest $request, $policy_cancellation)
    {
        try {
            $this->model->deleteItem($policy_cancellation,['task' => 'delete-item']);
            
            return $this->success('Thực hiện yêu cầu thành công!');
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function show(ShowRequest $request,$policy_cancellation)
    {
        try {
           $result =  $this->model->getItem([...$this->_params, 'id' => $policy_cancellation],['task' => 'item-info']);
            
            return $this->success('Lấy thông tin chi tiết thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function toggleStatus(DestroyRequest $request,$policy_cancellation)
    {
        try {
            $this->model->saveItem([...$this->_params, 'id' => $policy_cancellation],['task' => 'toggle-status']);
            
            return $this->success('Thực hiện yêu cầu thành công!');
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    
   
}
