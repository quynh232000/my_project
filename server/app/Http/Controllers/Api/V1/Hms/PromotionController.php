<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\Promotion\CreateRequest;
use App\Http\Requests\Api\V1\Hms\Promotion\DestroyRequest;
use App\Http\Requests\Api\V1\Hms\Promotion\ShowRequest;
use App\Http\Requests\Api\V1\Hms\Promotion\ToggleStatusRequest;
use App\Http\Requests\Api\V1\Hms\Promotion\UpdateRequest;
use App\Models\Api\V1\Hms\PromotionModel;
use DB;
use Illuminate\Http\Request;
use Str;


class PromotionController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PromotionModel();
    }
    public function index(Request $request)
    {
        try {
            $result = $this->model->listItem($this->_params,['task' => 'list-item']);

            return $this->paginated('Lấy thông tin thành công!',$result['data'],200,[
                'per_page'      => $result['items']->perPage(),
                'current_page'  => $result['items']->currentPage(),
                'total_page'    => $result['items']->lastPage(),
                'total_item'    => $result['items']->total(),
            ]);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function store(CreateRequest $request)
    {
        try {
           $result = $this->model->saveItem($this->_params,['task' => 'add-item']);
            
            return $this->success('Cập nhật thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function update(UpdateRequest $request,$promotion)
    {
        try {
           $result = $this->model->saveItem([...$this->_params, 'id' => $promotion],['task' => 'edit-item']);
            
            return $this->success('Cập nhật thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function show(ShowRequest $request,$promotion)
    {
        try {
           $result =  $this->model->getItem([...$this->_params,'id' => $promotion],['task' => 'item-info']);
            
            return $this->success('Lấy thông tin chi tiết thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function toggleStatus(ToggleStatusRequest $request,$promotion)
    {
        try {
            $this->model->saveItem([...$this->_params, 'id' => $promotion],['task' => 'toggle-status']);
            
            return $this->success('Thực hiện yêu cầu thành công!');
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    
   
}
