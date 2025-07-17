<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Hotel\Hotel\FilterRequest;
use App\Http\Requests\Api\V1\Hotel\Hotel\ShowRequest;
use App\Models\Api\V1\Hotel\HotelModel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HotelController extends ApiController
{
    use ApiResponse;
    public $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model             = new HotelModel();
    }
    public function index(Request $request) 
    {
        $item = $this->model->listItem($this->_params, ['task' => 'list']);
        return response()->json($item, $item['status_code'] );
    }
    public function search(Request $request) 
    {
        $item = $this->model->listItem($this->_params, ['task' => 'search']);
        return response()->json($item, $item['status_code'] );
    }
    public function filter(FilterRequest $request) 
    {
        try {
            
            $response           = $this->model->listItem($this->_params, ['task' => 'filter']);
    
            return $this->paginated('Lấy thông tin thành công!',$response->items(),200,[
                'per_page'      => $response->perPage(),
                'current_page'  => $response->currentPage(),
                'total_page'    => $response->lastPage(),
                'total_item'    => $response->total(),
            ]);

        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function show(ShowRequest $request,$hotel) 
    {
        try {
            $response           = $this->model->getItem([...$this->_params,'slug' => $hotel], ['task' => 'item-info']);
            
            return response(gzencode(json_encode([
                                'status'    => true,
                                'message'   => 'Lấy dữ liệu thành công',
                                'data'      => $response
                            ])))
                            ->header('Content-Type', 'application/json')
                            ->header('Content-Encoding', 'gzip');

         
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
}
