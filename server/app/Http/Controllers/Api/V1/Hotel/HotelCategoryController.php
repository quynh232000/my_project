<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Hotel\HotelCategory\ShowRequest;
use App\Models\Api\V1\Hotel\HotelCategoryModel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HotelCategoryController extends ApiController
{
    use ApiResponse;
    public $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model             = new HotelCategoryModel();
    }
    public function index(Request $request)
    {
        try {
            $result     = $this->model->listItem($this->_params, ['task' => 'list']);
            return $this->success('Lấy thông tin thành công!', $result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function show(ShowRequest $request, $hotel_category)
    {
        try {
            $result     = $this->model->getItem([...$this->_params, 'slug' => $hotel_category], ['task' => 'item-info']);
            return $this->success('Lấy thông tin thành công!', $result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function hotLocation(Request $request)
    {
        $item = $this->model->listItem($this->_params, ['task' => 'hot-location']);
        return response()->json($item, $item['status_code']);
    }
}
