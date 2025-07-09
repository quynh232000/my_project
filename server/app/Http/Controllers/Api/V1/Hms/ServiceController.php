<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\Service\IndexRequest;
use App\Models\Api\V1\Hms\ServiceModel;
use Illuminate\Http\Request;


class ServiceController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new ServiceModel();
    }
    public function index(IndexRequest $request)
    {
        try {
            $result = $this->model->listItem($this->_params,['task' => 'list-items']);
            if($result['status'] ){
                return $this->success('Lấy danh sách dịch vụ/ tiện ích thành công!',$result['data']);
            }else{
                return $this->error($result['message']);
            }
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
   
}
