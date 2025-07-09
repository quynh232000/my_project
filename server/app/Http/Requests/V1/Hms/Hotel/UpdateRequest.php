<?php

namespace App\Http\Requests\Api\V1\Hms\Hotel;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_HOTEL;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validate = [
            'name'              => 'required|string|min:3|max:50',
            'avg_price'         => 'required|numeric|min:0',
            'accommodation_id'  => "required|numeric|exists:".TABLE_HOTEL_ATTRIBUTE.",id",
            'stars'             => "required|numeric|in:0,1,2,3,4,5",
            'chain_id'          => 'sometimes|numeric|exists:'.TABLE_HOTEL_CHAIN.',id',
            'room_number'       => 'required|numeric|min:1',
            'time_checkin'      => 'required|date_format:H:i',
            'time_checkout'     => 'required|date_format:H:i',
            'country_id'        => 'required|numeric|exists:'.TABLE_GENERAL_COUNTRY.',id',
            'city_id'           => 'required|numeric|exists:'.TABLE_GENERAL_CITY.',id',
            'district_id'       => 'required|exists:'.TABLE_GENERAL_DISTRICT.',id',
            'ward_id'           => 'required|exists:'.TABLE_GENERAL_WARD.',id',
            'address'           => 'required|string|max:100',
            'latitude'          => 'required',
            'longitude'         => 'required',
            'construction_year' => 'required|numeric|min:1890|max:' . date('Y'),
            'bar_count'         => 'required|numeric|min:0',
            'floor_count'       => 'required|numeric|min:0',
            'restaurant_count'  => 'required|nullable|min:0',
            'language'          => 'required|exists:'.TABLE_GENERAL_COUNTRY.',id',
            'image'             => '',
        ];
        if(request()->hasFile('image')){
            $validate['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $validate;
    }

    public function messages()
    {
        return [];
    }
    public function attributes()
    {
        return [
            'name'              => 'tên khách sạn',
            'avg_price'         => 'giá trung bình',
            'accommodation_id'  => 'loại chỗ nghỉ',
            'stars'             => 'số sao',
            'rank'              => 'xếp hạng',
            'room_number'       => 'số phòng',
            'time_checkin'      => 'giờ nhận phòng',
            'time_checkout'     => 'giờ trả phòng',
            'country_id'        => 'quốc gia',
            'city_id'           => 'thành phố',
            'district_id'       => 'quận/huyện',
            'ward_id'           => 'phường/xã',
            'address'           => 'địa chỉ',
            'latitude'          => 'vĩ độ',
            'longitude'         => 'kinh độ',
            'construction_year' => 'năm xây dựng',
            'bar_count'         => 'số quầy bar',
            'floor_count'       => 'số tầng',
            'restaurant_count'  => 'số nhà hàng',
            'language'          => 'ngôn ngữ',
            'image'             => 'ảnh đại diện',
            'faqs'              => 'array',
            'faqs.*.question'   => 'required|string|max:100',
            'faqs.*.reply'      => 'nullable|string|max:100',
        ];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
}
