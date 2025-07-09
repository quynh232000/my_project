<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\Hotel\UpdateRequest;
use App\Models\Api\V1\Hms\HotelModel;
use DB;
use Http;
use Illuminate\Http\Request;

class HotelController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new HotelModel();
    }
    public function index(){
        try {
            $result = $this->model->listItem($this->_params,['task' => 'index']);
            if($result['status']){
                return $this->success('Lấy thông tin khách sạn thành công!',$result['data']);
            }else{
                return $this->error('token_expired', null, 401);
            }

        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function detail(){
        try {
            $result = $this->model->getItem($this->_params,['task' => 'detail']);
            return $this->success('Lấy thông tin khách sạn thành công!',$result);

        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function update(UpdateRequest $request,$hotel)
    {
        try {
            if($hotel != auth('hms')->user()->current_hotel_id){
                return $this->error('Khách sạn không hợp lệ');
            }
            $result = $this->model->saveItem($this->_params,['task' => 'add-item']);
            return $this->success('Cập nhật thành công!',$result);

        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function show($id)
    {
        try {
            if($id != auth('hms')->user()->current_hotel_id){
                return $this->error('Khách sạn không hợp lệ');
            }
            $result = $this->model->saveItem($this->_params,['task' => 'add-item']);
            return $this->success('Cập nhật thành công!',$result);

        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    

}
