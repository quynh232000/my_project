<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\BankModel;
use App\Models\Api\V1\Ecommerce\PaymentMethodModel;
use App\Models\Api\V1\Ecommerce\SettingModel;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function get_banks()
    {
        try {
            $data = BankModel::orderBy('symbol', 'asc')->get();
            return $this->successResponse('Lấy danh sách ngân hàng thành công!', $data);
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi: ' . $e->getMessage());
        }
    }
    public function get_payment_methods()
    {
        try {
            $data = PaymentMethodModel::where('is_show',1)->get();
            return $this->successResponse('Success', $data);
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi: ' . $e->getMessage());
        }
    }
    public function get_settings(Request $request)
    {
        try {
            if (!$request->type && $request->key) {
                return $this->errorResponse('error', 'Vui lòng truyền type & key');
            }
            $data = SettingModel::query();
            if ($request->type) {
                $data = $data->where('type', strtoupper($request->type));
            }
            if ($request->key) {
                $data = $data->where('key', strtoupper($request->key));
            }
            $data = $data->get();
            return $this->successResponse('Success', $data);
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi: ' . $e->getMessage());
        }
    }
}
