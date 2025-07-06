<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\AddressModel;
use App\Models\Api\V1\Ecommerce\DistrictModel;
use App\Models\Api\V1\Ecommerce\ProvinceModel;
use App\Models\Api\V1\Ecommerce\WardModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends ApiController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function get_provinces()
    {
        try {
            $data = ProvinceModel::select(['id', 'name'])->get();
            return $this->successResponse('Lấy danh sách tỉnh/thành thành công!', $data);
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi: ' . $e->getMessage());
        }
    }
     public function get_district($province_id)
    {
        try {
            if (!$province_id) {
                return $this->errorResponse('Vui lòng chọn tỉnh/thành');
            }
            if (!ProvinceModel::find($province_id)) {
                return $this->errorResponse('Tỉnh/thành không tồn tại');
            }
            $data = DistrictModel::select(['id', 'name'])->where('province_id', $province_id)->get();
            return $this->successResponse('Lấy danh sách quận/huyện thành công!', $data);
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi: ' . $e->getMessage());
        }
    }
    public function get_ward($district_id)
    {
        try {
            if (!$district_id) {
                return $this->errorResponse('Vui lòng chọn quận/huyện');
            }
            if (!DistrictModel::find($district_id)) {
                return $this->errorResponse('Quận/huyện không tồn tại');
            }
            $data = WardModel::select(['id', 'name', 'code'])->where('district_id', $district_id)->get();
            return $this->successResponse('Lấy danh sách phư��ng/xã thành công!', $data);
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi: ' . $e->getMessage());
        }
    }
    public function get_address(Request $request)
    {
        try {
            $page               = $request->page ?? 1;
            $limit              = $request->limit ?? 20;
            $address_default    = AddressModel::where(['user_id' => auth('ecommerce')->id(), 'is_default' => true])
                                ->with('province', 'district', 'ward')->first();
            if($request->type && $request->type =='default'){
                return $this->successResponse('success', $address_default);
            }
            if (!$address_default) {
                return $this->successResponsePagination('Bạn chưa có địa chỉ nào!', []);
            }
            $data               = AddressModel::where('user_id', auth('ecommerce')->id())
                                ->where('id', '!=', $address_default->id)
                                ->with('province', 'district', 'ward')
                                ->orderBy('created_at', 'desc')
                                ->paginate($limit, ['*'], 'page', $page);

            $allAddresses       = collect([$address_default])->merge($data->items());
            return $this->successResponsePagination('Lấy địa chỉ thành công', $allAddresses, $data);
        } catch (Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function delete_address($address_id)
    {
        try {
            $address            = AddressModel::find($address_id);
            if (!$address) {
                return $this->errorResponse('Địa chỉ không tồn tại');
            }
            if ($address->user_id != auth('ecommerce')->id()) {
                return $this->errorResponse('Bạn không có quyền xóa địa chỉ này');
            }
            $address->delete();
            return $this->successResponse('Xóa địa chỉ thành công');
        } catch (Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function update_address($address_id, Request $request)
    {
        try {
            $address            = AddressModel::find($address_id);
            if (!$address) {
                return $this->errorResponse('Địa chỉ không tồn tại');
            }
            if ($address->user_id != auth('ecommerce')->id()) {
                return $this->errorResponse('Bạn không có quyền!');
            }
            $data = request()->all();
            if ($request->receiver_name && $request->receiver_name != $address->receiver_name) {
                $address->receiver_name = $data['receiver_name'];
            }
            if ($request->address_detail && $request->address_detail != $address->address_detail) {
                $address->address_detail = $data['address_detail'];
            }
            if ($request->phone_number && $request->phone_number != $address->phone_number) {
                $address->phone_number = $data['phone_number'];
            }
            if ($request->province_id && $request->province_id != $address->province_id) {
                if (!ProvinceModel::find($request->province_id)) {
                    return $this->errorResponse('Tỉnh/Thành phố không tồn tại');
                }
                if (!DistrictModel::where(['id' => $request->district_id, 'province_id' => $request->province_id])->first()) {
                    return $this->errorResponse('Quận/Huyện không hợp lệ');
                }
                if (!WardModel::where(['id' => $request->ward_id, 'district_id' => $request->district_id])->first()) {
                    return $this->errorResponse('Phường/Xã không hợp lệ');
                }
                $address->province_id = $data['province_id'];
                $address->district_id = $data['district_id'];
                $address->ward_id = $data['ward_id'];
            }
            if ($request->is_default &&$request->is_default =='on') {
                AddressModel::where('user_id', auth('ecommerce')->id())->update(['is_default' => 0]);
                $address->is_default = 1;
            }
            $address->save();
            return $this->successResponse('Cập nhật địa chỉ thành công', $address);
        } catch (Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function set_default_address($address_id)
    {
        try {
            $address            = AddressModel::find($address_id);
            if (!$address) {
                return $this->errorResponse('Địa chỉ không tồn tại');
            }
            if ($address->user_id != auth('ecommerce')->id()) {
                return $this->errorResponse('Bạn không có quyền!');
            }
            AddressModel::where('user_id', auth('ecommerce')->id())->update(['is_default' => 0]);
            $address->is_default = 1;
            $address->save();
            return $this->successResponse('Cập nhật thành công');
        } catch (Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function get_address_by_id($address_id)
    {
        try {
            $address        = AddressModel::find($address_id);
            if (!$address) {
                return $this->errorResponse('Địa chỉ không tồn tại');
            }
            if ($address->user_id != auth('ecommerce')->id()) {
                return $this->errorResponse('Bạn không có quyền!');
            }
            return $this->successResponse('success', $address);
        } catch (Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function get_default_address()
    {
        try {
           $address         = AddressModel::where(['user_id'=>auth('ecommerce')->id(),'is_default'=>true])->with('province','district','ward')->first();
           if(!$address){
             return $this->errorResponse('Địa chỉ mặc định không tồn tại');
           }
            return $this->successResponse('success', $address);
        } catch (Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function create_address(Request $request)
    {
        try {
            $validate           = Validator::make($request->all(), [
                                    'receiver_name'     => 'required|string',
                                    'phone_number'      => 'required|',
                                    'province_id'       => 'required',
                                    'district_id'       => 'required',
                                    'ward_id'           => 'required',
                                    'address_detail'    => 'required'
                                ]);
            if ($validate->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin', $validate->errors());
            }
            if (!ProvinceModel::find($request->province_id)) {
                return $this->errorResponse('Tỉnh/Thành phố không tồn tại');
            }
            if (!DistrictModel::where(['id' => $request->district_id, 'province_id' => $request->province_id])->first()) {
                return $this->errorResponse('Quận/Huyện không hợp lệ');
            }
            if (!WardModel::where(['id' => $request->ward_id, 'district_id' => $request->district_id])->first()) {
                return $this->errorResponse('Phường/Xã không hợp lệ');
            }
            // Create address
            $address    = AddressModel::create([
                                                            'receiver_name'     => $request->receiver_name,
                                                            'user_id'           => auth('ecommerce')->id(),
                                                            'province_id'       => $request->province_id,
                                                            'district_id'       => $request->district_id,
                                                            'ward_id'           => $request->ward_id,
                                                            'phone_number'      => $request->phone_number,
                                                            'address_detail'    => $request->address_detail,
                                                        ]);
            if ($request->is_default && $request->is_default =='on') {
                AddressModel::where('user_id', auth('ecommerce')->id())->update(['is_default' => 0]);
                $address->is_default = 1;
                $address->save();
            } else {
                $address->is_default = false;
            }

            return $this->successResponse('Thêm địa chỉ thành công', $address);
        } catch (Exception $e) {
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
}
