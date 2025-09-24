<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\PriceType\DestroyRequest;
use App\Http\Requests\Api\V1\Hms\PriceType\ShowRequest;
use App\Http\Requests\Api\V1\Hms\PriceType\ToggleStatusRequest;
use App\Http\Requests\Api\V1\Hms\PriceType\UpdateRequest;
use App\Models\Api\V1\Hms\PriceTypeModel;
use Illuminate\Http\Request;


class PriceTypeController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PriceTypeModel();
    }
    public function index(Request $request){
        try {
            if(isset($request->list) && $request->list == 'all'){
                $result             = $this->model->listItem($this->_params,['task' => 'list-all']);
                return $this->success('Thành công!',$result);
            }else{
                $result             = $this->model->listItem($this->_params,['task' => 'list']);
                return $this->paginated('Lấy thông tin thành công!',$result->items(),200,[
                    'per_page'      => $result->perPage(),
                    'current_page'  => $result->currentPage(),
                    'total_page'    => $result->lastPage(),
                    'total_item'    => $result->total(),
                ]);
            }


        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function store(UpdateRequest $request)
    {
        try {
            if($request->id){
                $result = $this->model->saveItem($this->_params,['task' => 'edit-item']);
            }else{
                $result = $this->model->saveItem($this->_params,['task' => 'add-item']);
            }
            return $this->success('Cập nhật thành công!',$result);

        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function show(ShowRequest $request,$price_type)
    {
        try {
            
            $result = $this->model->getItem([...$this->_params,'id' => $price_type],['task' => 'detail']);
            
            return $this->success('Lấy dữ liệu thành công!',$result);

        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function destroy(DestroyRequest $request,$price_type)
    {
        try {
            
            $this->model->deleteItem([...$this->_params, 'id' => $price_type],['task' => 'delete-item']);
            
            return $this->success('Thực hiện yêu cầu thành công!');

        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function toggleStatus(ToggleStatusRequest $request,$price_type)
    {
        try {
            $result = $this->model->saveItem([...$this->_params, 'id' => $price_type],['task' => 'toggle-status']);
            
            return $this->success('Thực hiện yêu cầu thành công!', $result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
   
}
