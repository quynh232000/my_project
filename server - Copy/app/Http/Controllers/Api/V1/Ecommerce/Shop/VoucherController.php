<?php

namespace App\Http\Controllers\Api\V1\Ecommerce\Shop;

use Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\V1\Ecommerce\VoucherModel;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{


    public function voucher_index(Request $req)
    {
        try {

            $filters = [
                [
                    'column' => 'name',
                    'value' => $req->name,
                ],
                [
                    'column' => 'code',
                    'value' => $req->code,
                ],
                // [
                //     'column' => 'discount_amount',
                //     'value' => $req->discount_amount,
                // ],
            ];

            $limit = $req->limit ?? 5;
            $page = $req->page ?? 1;

            $sort_by = request('sort_by', 'updated_at');

            $sort_direction = request('sort_direction', 'desc');

            $query = VoucherModel::where('shop_id', auth('ecommerce')->user()->shop->id)
                ->filterAndSort($filters, $sort_by, $sort_direction);
            if (!empty($req->status)) {
                switch ($req->status) {
                    case 'ACTIVE':
                        $query->where('date_start', '<=', Carbon::now())
                            ->where('date_end', '>=', Carbon::now());
                        break;
                    case 'COMMING_SOON':
                        $query->where('date_start', '>', Carbon::now());
                        break;
                    case 'EXPIRED':
                        $query->where('date_end', '<', Carbon::now());
                        break;
                }
            }
            $vouchers = $query->paginate($limit, ['*'], 'page', $page);

            return $this->successResponsePagination('Lấy danh sách vouchers thành công', $vouchers->items(), $vouchers);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function voucher_get($id)
    {
        try {

            $voucher = VoucherModel::where(['shop_id' => auth('ecommerce')->user()->shop->id, 'id' => $id])->first();

            if (!$voucher) {
                return $this->errorResponse('Voucher không tồn tại');
            }

            return $this->successResponse('success', $voucher);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function voucher_create(Request $req)
    {
        try {

            $validator = Validator::make($req->all(), [
                'code' => 'required',
                'name' => 'required|min:6|max:255',
                'date_start' => 'required',
                'date_end' => 'required',
                'discount_amount' => 'required|numeric|min:1',
                'minimum_price' => 'required|numeric|min:1',
                'quantity' => 'required|numeric|min:1|max:10000',
                'max_usage_per_user' => 'required|numeric|min:1|max:10',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin', $validator->errors());
            }

            if (Voucher::where('code', $req->code)->first()) {
                return $this->errorResponse('Voucher với mã này đã tồn tại. Vui lòng sử dụng mã khác.');
            }

            if ($req->date_start > $req->date_end || strtotime($req->date_end) < time()) {
                return $this->errorResponse('Ngày hết hạn voucher không hợp lệ');
            }

            // if (strtotime($req->date_start) < time()) {
            //     return $this->errorResponse('Ngày bắt đầu voucher không hợp lệ');
            // }

            if (!preg_match('/^[a-zA-Z0-9]{9}$/', $req->code)) {
                return $this->errorResponse('Mã voucher chưa hợp lệ');
            }

            $data =
                [
                    'code' => mb_strtoupper($req->code),
                    'name' => trim($req->name),
                    'date_start' => $req->date_start,
                    'date_end' => $req->date_end,
                    'discount_amount' => $req->discount_amount,
                    'minimum_price' => $req->minimum_price,
                    'quantity' => $req->quantity,
                    'max_usage_per_user' => $req->max_usage_per_user,
                    'from' => 'SHOP',
                    'shop_id' => auth('ecommerce')->user()->shop->id,
                ];

            $voucher = VoucherModel::create(
                $data
            );

            return $this->successResponse('Tạo voucher thành công.', $voucher);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function voucher_update(Request $req, $id)
    {
        try {
            $voucher = VoucherModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$voucher) {
                return $this->errorResponse('Voucher không tồn tại');
            }

            $validator = Validator::make($req->all(), [
                'name' => "required",
                'discount_amount' => 'numeric|min:1',
                'minimum_price' => 'numeric|min:1',
                'quantity' => 'numeric|min:1|max:10000',
                'max_usage_per_user' => 'numeric|min:1|max:10',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(false, $validator->errors());
            }

            if (strtotime($req->date_end) < time()) {
                return $this->errorResponse('Thời hạn voucher được điều chỉnh không hợp lệ.');
            }

            if ($voucher['used_quantity'] != 0) {
                return $this->errorResponse('Voucher đã được sử dụng, vui lòng không thay đổi.');
            }

            $changed_features = ['name', 'date_end', 'discount_amount', 'minimum_price', 'quantity', 'max_usage_per_user'];

            foreach ($changed_features as $value) {
                if ($req->$value && $voucher->$value != $req->$value) {
                    $voucher->$value = $req->$value;
                }
            }

            $voucher->updated_at = Carbon::now();

            $voucher->save();

            return $this->successResponse('Cập nhật voucher thành công.', $voucher);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function voucher_delete($id)
    {
        try {
            $voucher = VoucherModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$voucher) {
                return $this->errorResponse('Voucher không tồn tại');
            }

            if ($voucher['used_quantity'] != 0) {
                return $this->errorResponse('Voucher đã được sử dụng, vui lòng không xoá.');
            }

            $voucher->delete();

            return $this->successResponse('Xóa voucher thành công.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function voucher_restore($id)
    {
        try {
            $voucher = VoucherModel::where('user_id', auth()->id())->where('id', $id)->first();

            if ($voucher) {
                return $this->errorResponse('Không thể khôi phục voucher đang hoạt động.');
            }

            $voucher_deleted = VoucherModel::withTrashed()->where('user_id', auth()->id())->where('id', $id)->first();

            if (!$voucher_deleted) {
                return $this->errorResponse('Voucher không tồn tại trong thùng rác.');
            }

            VoucherModel::withTrashed()->where('user_id', auth()->id())->where('id', $id)->first()->restore();

            return $this->successResponse('Khôi phục voucher thành công.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function voucher_clone(Request $req, $id)
    {
        try {

            $voucher = VoucherModel::where(['shop_id' => auth('ecommerce')->user()->shop->id, 'id' => $req->id])->first();

            if (!$voucher) {
                return $this->errorResponse('Voucher không tồn tại');
            }

            $voucher_clone = $voucher->first()->replicate();
            $voucher_clone->name .= '-' . time();
            // code
            do {
                $code_new = substr($voucher->code, 0, 4) . Str::random(5);
            } while (VoucherModel::where(['code' => $code_new])->exists());
            $voucher_clone->code = strtoupper($code_new);

            $voucher_clone->created_at = Carbon::now();
            $voucher_clone->updated_at = Carbon::now();

            $voucher_clone->save();

            return $this->successResponse('Sao chép voucher thành công.', $voucher_clone);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
