<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\Customer\ShowRequest;
use App\Http\Requests\Api\V1\Hms\Customer\UpdateRequest;
use App\Models\Api\V1\Hms\CustomerModel;
use Illuminate\Http\Request;

class CustomerController extends HmsController
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
        try {
            
            $result = $this->model->listItem($this->_params,['task'=>'list']);

            return $this->success('Thành công!',$result);

        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
        
    }
    public function store(UpdateRequest $request)
    {
        try {
            
            $result = $this->model->saveItem($this->_params,['task'=>isset($request->id) ? 'edit-item' : 'add-item']);

            return $this->success('Tạo yêu cầu thành công!',$result);
            
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
        
    }
    public function show(ShowRequest $request,$customer)
    {
        try {
            $this->_params['id']    = $customer;
            $result                 = $this->model->getItem($this->_params,['task' => 'detail']);

            return $this->success('Tạo yêu cầu thành công!',$result);
            
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
        
    }
}
