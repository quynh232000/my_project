<?php

namespace App\Http\Requests\Api\V1\Hms\RoomStatus;

use App\Models\Api\V1\Hms\PriceTypeModel;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_ROOM_STATUS;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validate = [
            'start_date'            => ['required', 'date_format:Y-m-d'],
            'end_date'              => ['required', 'date_format:Y-m-d', 'after_or_equal:start_date'],

            'room_ids'              => ['required', 'array', 'min:1'],
            'room_ids.*'            => ['integer', Rule::exists(TABLE_HOTEL_ROOM, 'id')
                                        ->where('hotel_id', auth('hms')->user()->current_hotel_id),
                                    ],

            'price_type'            => [],
            'day_of_week'           => ['required', 'array'],
            'day_of_week.monday'    => ['nullable', "in:close,open"],
            'day_of_week.tuesday'   => ['nullable', "in:close,open"],
            'day_of_week.wednesday' => ['nullable', "in:close,open"],
            'day_of_week.thursday'  => ['nullable', "in:close,open"],
            'day_of_week.friday'    => ['nullable', "in:close,open"],
            'day_of_week.saturday'  => ['nullable', "in:close,open"],
            'day_of_week.sunday'    => ['nullable', "in:close,open"],
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


