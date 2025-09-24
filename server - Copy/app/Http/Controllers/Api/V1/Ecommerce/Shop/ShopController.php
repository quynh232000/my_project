<?php

namespace App\Http\Controllers\Api\V1\Ecommerce\Shop;

use App\Http\Controllers\Controller;
use App\Models\Admin\UserRoleModel;
use App\Models\Api\V1\Ecommerce\BankModel;
use App\Models\Api\V1\Ecommerce\RoleModel;
use App\Models\Api\V1\Ecommerce\ShopModel;
use App\Models\Api\V1\Ecommerce\UserBankModel;
use App\Models\Api\V1\Ecommerce\UserModel;
use App\Models\Api\V1\Ecommerce\VerifyShopModel;
use App\Services\FileService;
use App\Services\GhnApiService;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Str;
use Illuminate\Support\Facades\Redis;
class ShopController extends Controller
{

    public function shop_update_info(Request $req)
    {
        DB::beginTransaction();
        try {
            $is_shop = in_array('Seller', auth('ecommerce')->user()->roles()->toArray());

            if ($is_shop) {
                $validator = Validator::make($req->all(), [
                    'name' => 'required',
                    'phone_number' => 'required',
                    'address_detail' => 'required|min:30',
                    'district_id' => 'required',
                ]);

                if ($validator->fails()) {
                    DB::rollback();
                    return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors(), 400);
                }
                $shop = ShopModel::where('user_id', auth('ecommerce')->id())->first();

                if ($req->user_bank_name && $req->input('code') && $req->bank_id) {

                    if (!BankModel::find($req->bank_id)) {
                        DB::rollback();
                        return $this->errorResponse('Ngân hàng không tồn tại. Vui lòng thử lại', null, 400);
                    }
                    $check_bank = UserBankModel::where(['bank_id' => $req->bank_id, 'code' => $req->input('code')])->exists();
                    if (!$check_bank) {

                        UserBankModel::create([
                            'name' => $req->user_bank_name,
                            'code' => $req->input('code'),
                            'user_id' => auth('ecommerce')->id(),
                            'bank_id' => $req->bank_id,
                        ]);
                    }
                    ;
                }
                if (isset($req->name) && !empty($req->name)) {
                    $shop->name = ucwords(trim($req->name));

                    $slug = Str::slug(trim($req->name));

                    $check_slug = ShopModel::where('slug', $slug)->count();
                    if ($check_slug > 0) {
                        $slug = $slug . '-' . $check_slug;
                    }

                    $shop->slug = $slug;
                }
                if (isset($req->phone_number) && !empty($req->phone_number)) {
                    $phone_regex = "/^0([1-9]{1})([0-9]{7,10})$/";
                    if (preg_match($phone_regex, $req->phone_number) == 0) {
                        return $this->errorResponse('Số điện thoại không đúng định dạng.', $validator->errors(), 400);
                    }
                    ;
                    $shop->phone_number = $req->phone_number;
                }
                if ($req->file('logo')) {
                    $fileService = new FileService();

                    $logo_url = $fileService->uploadFile($req->file('logo'), 'shop', auth('ecommerce')->id())['url'];

                    $shop->logo = $logo_url;
                }
                if ($req->address_detail && $req->address_detail != $shop->address_detail) {
                    $shop->address_detail = $req->address_detail;
                }
                $shop->save();
                DB::commit();
                return $this->successResponse('Cập nhật thông tin Seller thành công.', $shop);
            } else {
                $validator = Validator::make($req->all(), [
                    'name' => 'required',
                    'logo' => 'sometimes|max:20480|image',
                    'phone_number' => 'required',
                    'address_detail' => 'required|min:30',
                    'email' => 'required|email',
                    'code' => 'required',
                    // 'code_verify' => 'required',
                    'district_id' => 'required',
                    'ward_code' => 'required',
                    'bank_id' => 'required',
                ]);

                if ($validator->fails()) {
                    DB::rollback();
                    return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors(), 400);
                }
                // check verify email shop
                $check_code = null;
                if ($req->email != auth('ecommerce')->user()->email) {
                    $check_code = VerifyShopModel::where('email', $req->email)->first();
                    if (!$check_code) {
                        DB::rollback();
                        return $this->errorResponse('Vui lòng xác thực email của bạn!');
                    }
                    if (!$check_code->is_verified && $check_code->code != $req->code_verify) {
                        DB::rollback();
                        return $this->errorResponse('Mã xác thực không đúng. Vui lòng thử lại!');
                    }
                }
                //  check bank
                if (!BankModel::find($req->bank_id)) {
                    DB::rollback();
                    return $this->errorResponse('Ngân hàng không tồn tại. Vui lòng thử lại', null, 400);
                }

                if (!$req->user_bank_name || !$req->input('code') || !$req->bank_id) {
                    DB::rollback();
                    return $this->errorResponse('Vui lòng nhập thông tin ngân hàng để trở thành nhà bán hàng.', null, 400);
                }

                if (!BankModel::find($req->bank_id)) {
                    DB::rollback();
                    return $this->errorResponse('Ngân hàng không tồn tại. Vui lòng thử lại', null, 400);
                }

                if (UserBankModel::where('code', $req->input('code'))->count() != 0) {
                    DB::rollback();
                    return $this->errorResponse('Số tài khoản ngân hàng này đã được sử dụng. Vui lòng thử lại.', null, 400);
                }

                $phone_regex = "/^0([1-9]{1})([0-9]{7,10})$/";
                if (preg_match($phone_regex, $req->phone_number) == 0) {
                    DB::rollback();
                    return $this->errorResponse('Số điện thoại không đúng định dạng.', $validator->errors(), 400);
                }

                if ($req->hasFile('logo')) {
                    $fileService = new FileService();
                    $logo_url = $fileService->uploadFile($req->file('logo'), 'shop', auth('ecommerce')->id())['url'];
                } else {
                    $logo_url = UserModel::find(auth('ecommerce')->id())->pluck('avatar_url')->first();
                }


                $slug = Str::slug(trim($req->name));

                $check_slug = ShopModel::where('slug', $slug)->count();
                if ($check_slug > 0) {
                    $slug = $slug . '-' . bin2hex(random_bytes(3));
                }
                // check shop in GHN
                $GhnApiService = new GhnApiService();
                $response = $GhnApiService->get_data('/v2/shop/all');
                if (!$response->successful()) {
                    DB::rollback();
                    return $this->errorResponse('Lỗi kiểm tra Shop trên GHN: ', $response->body());
                }
                $data_response = $response->json()['data']['shops'];
                $shop_ghn = null;
                foreach ($data_response as $shop_item) {
                    if ($shop_item['address'] == $req->email) {
                        $shop_ghn = $shop_item;
                        break;
                    }
                }
                $data = [
                    'name' => ucwords(trim($req->name)),
                    'slug' => $slug,
                    'logo' => $logo_url,
                    'phone_number' => $req->phone_number,
                    'address_detail' => $req->address_detail,
                    'user_id' => auth('ecommerce')->id(),
                    'email' => $req->email,
                    'district_id' => $req->district_id,
                    'ward_code' => $req->ward_code
                ];
                if ($shop_ghn) {
                    $data['district_id'] = $shop_ghn['district_id'];
                    $data['ward_code'] = $shop_ghn['ward_code'];
                    $data['shop_code'] = $shop_ghn['_id'];
                    $title = 'Thông tin Shop của bạn đã được cập nhật từ GHN thành công!';
                } else {
                    $create_response = $GhnApiService->post_data('/v2/shop/register', [
                        "district_id" => 1550,
                        "ward_code" => $req->ward_code,
                        "name" => $req->name,
                        "phone" => $req->phone_number,
                        "address" => $req->email
                    ]);
                    if (!$create_response->successful()) {
                        // DB::rollback();
                        // return $this->errorResponse('Đã có lỗi khi tạo Shop trên GHN: ', $create_response->body());
                        $data['shop_code'] = '5506575';
                    } else {
                        $data['shop_code'] = $create_response->json()['data']['shop_id'];

                    }
                    $title = 'Đăng ký trở thành nhà bán hàng thành công';
                }
                ShopModel::create($data);
                // update verify email shop
                if ($check_code) {
                    $check_code->code = '';
                    $check_code->is_verified = true;
                    $check_code->save();
                }
                UserBankModel::create([
                    'name' => $req->user_bank_name,
                    'code' => $req->input('code'),
                    'user_id' => auth('ecommerce')->id(),
                    'bank_id' => $req->bank_id,
                ]);
                $role_id = RoleModel::where('name','LIKE','%Seller%')->first()->id ?? 3;
                UserRoleModel::create([
                    'user_id' => auth('ecommerce')->id(),
                    'role_id' => $role_id
                ]);
                DB::commit();
                return $this->successResponse($title, $data);
            }
        } catch (Exception $e) {
            DB::rollback();
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }

    public function shop_delete_bank_account($id)
    {

        try {
            $bank_count = UserBankModel::where('user_id', auth('ecommerce')->id())->count();

            if ($bank_count == 1) {
                return $this->errorResponse('Không thể xóa tài khoản ngân hàng duy nhất của shop.');
            }

            $bank_account = UserBankModel::where('user_id', auth('ecommerce')->id())->find($id);

            if (!$bank_account) {
                return $this->errorResponse('Tài khoản ngân hàng không tồn tại');
            }

            $bank_account->delete();

            return $this->successResponse('Xóa tài khoản ngân hàng thành công.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function verify_email_shop(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required'
            ]);
            if ($validate->fails()) {
                return $this->errorResponse('Vui lòng nhập email.', $validate->errors(), 400);
            }
            $is_verified = $request->email == auth('ecommerce')->user()->email ? true : false;
            $checkCode = VerifyShopModel::where(['email' => $request->email])->first();
            $randomNumber = rand(100000, 999999);
            if ($checkCode) {
                $checkCode->code = $randomNumber;
                $checkCode->is_verified = $is_verified;
                $checkCode->save();
            } else {
                VerifyShopModel::create([
                    'email' => $request->email,
                    'code' => $randomNumber,
                    'is_verified' => $is_verified
                ]);
            }
            // send mail
            if (!$is_verified) {
                $data['email'] = $request->email;
                $data['title'] = $randomNumber . " là mã xác nhận của bạn";
                $data['code'] = $randomNumber;

                Mail::send("email.verifyemail", ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });
                return $this->successResponse('Đã gửi mã xác nhận qua Email thành công.');
            }
            return $this->successResponse('Đã xác nhận email thành công.');

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function shop_info()
    {
        try {
            // $data =UserBank::where('user_id',auth('ecommerce')->id())->with('bank')->limit(20)->get();
            $shop_info = ShopModel::where('user_id', auth('ecommerce')->id())->with('district')->first();
            $shop_info->banks = $shop_info->banks();
            $shop_info->ward = $shop_info->ward();
            return $this->successResponse('success', $shop_info);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function shop_list_home(Request $req)
    {
        try {
            $key = json_encode($req->all());
            if (config('app.run_redis')) {
                $result = Redis::get($key);
                if ($result) {
                    return json_decode($result)->original;
                }
            }
            $data = ShopModel::select('id', 'name', 'logo', 'bio', 'slug')
                ->withCount('product')->orderBy('product_count', 'desc')
                ->limit($req->limit ?? 20)->get();

            $response = $this->successResponse('success', $data);
            if (config('app.run_redis')) {
                $result = Redis::set($key, json_encode($response));
            }

            return $response;

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
