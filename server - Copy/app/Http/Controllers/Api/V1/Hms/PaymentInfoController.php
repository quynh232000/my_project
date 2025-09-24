<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\PaymentInfo\ShowRequest;
use App\Http\Requests\Api\V1\Hms\PaymentInfo\StoreRequest;
use App\Http\Requests\Api\V1\Hms\PaymentInfo\UpdateRequest;
use App\Models\Api\V1\Hms\PaymentInfoModel;
use Illuminate\Http\Request;


class PaymentInfoController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PaymentInfoModel();
    }
    public function store(StoreRequest $request)
    {
        try {
            $result = $this->model->saveItem($this->_params,['task' => 'add-item']);
            return $this->success('Thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function update(UpdateRequest $request,$payment_info)
    {
        try {
            $result = $this->model->saveItem([...$this->_params, 'id' => $payment_info],['task' => 'update-item']);

            if(!$result['status']){
                return $this->error($result['message'],$result['data']);
            }
            return $this->success($result['message'],$result['data']);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function show(ShowRequest $request,$payment_info)
    {
        try {
            $result   = $this->model->getItem([...$this->_params, 'id' => $payment_info],['task' => 'detail']);
            
            return $this->success('Thành công!',$result);
            
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function index()
    {
        try {
            $result   = $this->model->listItem($this->_params,['task' => 'list']);
            
            return $this->paginated('Thành công!',$result->items(),200,[
                'per_page'      => $result->perPage(),
                'current_page'  => $result->currentPage(),
                'total_page'    => $result->lastPage(),
                'total_item'    => $result->total(),
            ]);
            
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
   
}
