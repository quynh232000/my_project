<?php

namespace App\Http\Requests\Api\V1\Hms\RoomQuantity;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_ROOM_QUANTITY;
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
            'day_of_week.monday'    => ['nullable', 'integer', 'min:0'],
            'day_of_week.tuesday'   => ['nullable', 'integer', 'min:0'],
            'day_of_week.wednesday' => ['nullable', 'integer', 'min:0'],
            'day_of_week.thursday'  => ['nullable', 'integer', 'min:0'],
            'day_of_week.friday'    => ['nullable', 'integer', 'min:0'],
            'day_of_week.saturday'  => ['nullable', 'integer', 'min:0'],
            'day_of_week.sunday'    => ['nullable', 'integer', 'min:0'],
        ];
       
       
        return $validate;
    }

    public function messages()
    {
        return [
            'end_date.after_or_equal'       => 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.',
            // Cho từng ngày (quantity / price mode)
            'day_of_week.monday.integer'    => 'Giá trị của thứ hai phải là số.',
            'day_of_week.tuesday.integer'   => 'Giá trị của thứ ba phải là số.',
            'day_of_week.wednesday.integer' => 'Giá trị của thứ tư phải là số.',
            'day_of_week.thursday.integer'  => 'Giá trị của thứ năm phải là số.',
            'day_of_week.friday.integer'    => 'Giá trị của thứ sáu phải là số.',
            'day_of_week.saturday.integer'  => 'Giá trị của thứ bảy phải là số.',
            'day_of_week.sunday.integer'    => 'Giá trị của chủ nhật phải là số.',
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
