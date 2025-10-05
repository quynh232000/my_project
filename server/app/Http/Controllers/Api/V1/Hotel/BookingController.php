<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Hotel\Booking\OrderRequest;
use App\Http\Requests\Api\V1\Hotel\Booking\OrderVerifyRequest;
use App\Models\Api\V1\Hotel\BookingModel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BookingController extends ApiController
{
    use ApiResponse;
    public $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model             = new BookingModel();
    }
    public function order(OrderRequest $request)
    {
        try {

            $response           = $this->model->saveItem([...$this->_params, ...($request->all() ?? [])], ['task' => 'add-item']);
            if ($response['status']) {
                return $this->success($response['message'] ?? '', $response['data'] ?? null, 200);
            } else {
                return $this->error($response['message'] ?? '', $response['data'] ?? null, 200);
            }
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function order_verify(OrderVerifyRequest $request)
    {
        try {
            $response           = $this->model->getItem($this->_params, ['task' => 'item-by-code']);
            return $this->success('Lấy thông tin thành công!', $response, 200);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function info(OrderRequest $request)
    {
        try {
            $response           = $this->model->getItem([...$this->_params, ...($request->all() ?? [])], ['task' => 'item-info']);
            if ($response['status']) {
                return $this->success($response['message'], [...$response['data'], ...($request->all() ?? [])], 200);
            } else {
                return $this->error($response['message'], $response['data'] ?? null, 200);
            }
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
}
