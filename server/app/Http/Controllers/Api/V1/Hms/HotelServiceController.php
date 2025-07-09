<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\HotelService\IndexRequest;
use App\Http\Requests\Api\V1\Hms\HotelService\UpdateRequest;
use App\Models\Api\V1\Hms\HotelServiceModel;
use Illuminate\Http\Request;


class HotelServiceController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new HotelServiceModel();
    }
    public function index(IndexRequest $request)
    {
        try {
            $result = $this->model->listItem($this->_params,['task' => 'list-item']);
            if($result['status'] ){
                return $this->success('Lấy dữ liệu thành công!',$result['data']);
            }else{
                return $this->error($result['message']);
            }
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function store(UpdateRequest $request){
        try {
            $this->model->saveItem($this->_params,['task' => 'edit-item']);
            return $this->success('Cập nhật dịch vụ tiện ích thành công!');
            
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
   
}
