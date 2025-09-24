<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\UserVoucherModel;
use App\Models\Api\V1\Ecommerce\VoucherModel;
use Exception;
use Illuminate\Http\Request;

class VoucherController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new VoucherModel();
        parent::__construct($request);
    }
    public function index(Request $request){
        try {
            $result = $this->table->listItem($this->_params,['task' => 'list']);
            if(!$result) return $this->error('Thông tin không hợp lệ');
            return $this->successResponsePagination('Ok',$result->items(), $result);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra ', $e->getMessage());
        }
    }
    public function my_voucher(Request $request)
    {
        try {
            $vouchers = UserVoucherModel::where(['user_id' => auth('ecommerce')->id()])->with('voucher.shop');
            $vouchers->when($request->type, function ($query) use ($request) {
                switch ($request->type) {
                    case 'not_use':
                        $query->where('is_used', false);
                        break;
                    case 'used':
                        $query->where('is_used', true);
                        break;
                }
            });
            $vouchers->when($request->search, function ($query) use ($request) {
                $query->join('vouchers', 'vouchers.id', '=', 'user_vouchers.id')
                    ->where('vouchers.code', 'like', '%' . $request->search . '%')
                    ->orWhere('vouchers.name', 'like', '%' . $request->search . '%');
            });

            $vouchers = $vouchers->orderBy('created_at', 'desc')->paginate($request->get('limit', 20), ['*'], 'page', $request->get('page', 1));
            $vouchers->getCollection()->transform(function ($item) {
                $item->voucher->is_save = $item->voucher->is_save();
                return $item;
            });
            return $this->successResponsePagination('success', $vouchers->items(), $vouchers);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
