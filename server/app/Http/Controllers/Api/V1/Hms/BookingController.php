<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\Booking\IndexRequest;
use App\Http\Requests\Api\V1\Hms\Booking\ShowRequest;
use App\Models\Api\V1\Hms\BookingModel;
use Illuminate\Http\Request;

class BookingController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new BookingModel();
    }
    public function index(IndexRequest $request){
        try {
            $result         = $this->model->listItem($this->_params,['task' => 'index']);
            
            return $this->paginated('Lấy thông tin thành công!',$result->items(),200,[
                    'per_page'      => $result->perPage(),
                    'current_page'  => $result->currentPage(),
                    'total_page'    => $result->lastPage(),
                    'total_item'    => $result->total(),
                ]);
        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function show(ShowRequest $request,$booking)
    {
        try {
           $result =  $this->model->getItem([...$this->_params,'id' => $booking],['task' => 'item-info']);
            
            return $this->success('Lấy thông tin chi tiết thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
}
