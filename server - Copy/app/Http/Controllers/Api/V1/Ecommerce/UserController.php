<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\CoinTransactionModel;
use App\Models\Api\V1\Ecommerce\UserModel;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new UserModel();
        parent::__construct($request);
    }
   public function update_info(Request $request)
    {
        try {
            $user = auth('ecommerce')->user();
            if ($request->full_name && $request->full_name != $user->full_name) {
                $user->full_name = $request->full_name;
            }
            if ($request->phone_number && $request->phone_number != $user->phone_number) {
                $user->phone_number = $request->phone_number;
            }
            if ($request->address && $request->address != $user->address) {
                $user->address = $request->address;
            }
            if ($request->birthday && $request->birthday != $user->birthday) {
                $user->birthday = $request->birthday;
            }
            if ($request->bio && $request->bio != $user->bio) {
                $user->bio = $request->bio;
            }
            $fileService = new FileService();
            if ($request->hasFile('avatar')) {
                $file               = $fileService->uploadFile($request->file('avatar'), 'ecommerce.auth.profile', $user->id)['url'];
                $user->avatar   = $file;
            }

            $user->save();
            $roles              = $user->roles();
            $user->shop;
            $user->roles        = $roles;
            $user->total_coin   = $user->total_coin();
            return $this->successResponse('Cập nhật thông tin tài khoản thành công!', $user);
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi: ' . $e->getMessage(), null, 500);
        }
    }
    public function change_password(Request $request)
    {
        try {
            $validate       = Validator::make($request->all(), [
                                'password_old'      => 'required',
                                'password_new'      => 'required',
                                'password_confirm'  => 'required',
                            ]);
            if ($validate->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validate->errors());
            }
            if ($request->password_new != $request->password_confirm) {
                return $this->errorResponse('Mật khẩu xác nhận không khớp!');
            }

            $user = auth('ecommerce')->user();
            if (!Hash::check($request->password_old, $user->password)) {
                return $this->errorResponse('Mật khẩu cũ không đúng!');
            }
            $user->password     = Hash::make($request->password_new);
            $user->save();
            return $this->successResponse('Cập nhật mật khẩu mới thành công!');
        } catch (Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }
    public function coin_history(Request $request)
    {
        try {
            $coin_last      = CoinTransactionModel::where(['user_id' => auth('ecommerce')->id()])
                            ->orderBy('id', 'desc')
                            ->value('balance_after');
            $total_coin     = $coin_last ? $coin_last : 0;

            $page           = $request->page ?? 1;
            $limit          = $request->limit ?? 20;
            $data           = CoinTransactionModel::where(['user_id' => auth('ecommerce')->id()]);
            if (!empty($request->type)) {
                if ($request->type == 'in') {
                    $data->where('amount', '>', 0);
                }
                if ($request->type == 'out') {
                    $data->where('amount', '<', 0);
                }
            }
            $data = $data->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page);

            return $this->successResponsePagination('Lấy danh sách lịch sử Quin Coins thành công!', ['total_coin' => $total_coin, 'histories' => $data->items()], $data);
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi:  ' . $e->getMessage());
        }
    }
}
