<?php

namespace App\Http\Requests\Api\V1\Hms\PriceSetting;

use App\Models\Api\V1\Hms\PriceTypeModel;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_PRICE_SETTING;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validate = [
            'room_id'           => ['required', 'integer', 
                                        Rule::exists(TABLE_HOTEL_ROOM, 'id')
                                        ->where(function ($query) {
                                        $query->where('hotel_id', auth('hms')->user()->current_hotel_id);
                                    })],
            'price_type_id'     => ['required', function ($attribute, $value, $fail) {
                                        if (!is_numeric($value)) {
                                            $fail("Giá trị {$value} không hợp lệ. Chỉ chấp nhận số.");
                                        }
                                        if (is_numeric($value)) {
                                            if($value != 0){
                                                $exists = PriceTypeModel::where('id', $value)->exists();
                                                if (!$exists) {
                                                    return $fail("Giá trị '{$value}' không tồn tại trong bảng price_types.");
                                                }
                                            }
                                        }
                                }],
            'data'              => ['required', 'array', 'min:1'],
            'data.*.capacity'   => ['required', 'integer', 'min:1'],
            'data.*.price'      => ['required', 'numeric', 'min:0'],
            'data.*.status'     => ['required', 'in:active,inactive'],
        ];
       
       
        return $validate;
    }

    public function messages()
    {
        return [
            'end_date.after_or_equal'       => 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.',
             // Cho từng ngày (status mode)
            'day_of_week.monday.in'         => 'Thứ hai chỉ chấp nhận giá trị "open" hoặc "close".',
            'day_of_week.tuesday.in'        => 'Thứ ba chỉ chấp nhận giá trị "open" hoặc "close".',
            'day_of_week.wednesday.in'      => 'Thứ tư chỉ chấp nhận giá trị "open" hoặc "close".',
            'day_of_week.thursday.in'       => 'Thứ năm chỉ chấp nhận giá trị "open" hoặc "close".',
            'day_of_week.friday.in'         => 'Thứ sáu chỉ chấp nhận giá trị "open" hoặc "close".',
            'day_of_week.saturday.in'       => 'Thứ bảy chỉ chấp nhận giá trị "open" hoặc "close".',
            'day_of_week.sunday.in'         => 'Chủ nhật chỉ chấp nhận giá trị "open" hoặc "close".',

        ];
    }
    public function attributes()
    {
        return [
            'start_date'            => 'ngày bắt đầu',
            'end_date'              => 'ngày kết thúc',
            'room_ids'              => 'danh sách phòng',
            'room_ids.*'            => 'ID phòng',

            'day_of_week'           => 'ngày trong tuần',
            'day_of_week.monday'    => 'thứ hai',
            'day_of_week.tuesday'   => 'thứ ba',
            'day_of_week.wednesday' => 'thứ tư',
            'day_of_week.thursday'  => 'thứ năm',
            'day_of_week.friday'    => 'thứ sáu',
            'day_of_week.saturday'  => 'thứ bảy',
            'day_of_week.sunday'    => 'chủ nhật',
        ];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
}


