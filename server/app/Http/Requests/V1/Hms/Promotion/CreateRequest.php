<?php

namespace App\Http\Requests\Api\V1\Hms\Promotion;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_PROMOTION;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'name'              => 'required|string|max:255',
            'price_type_ids'    => 'required|array|min:1',
            'price_type_ids.*'  => [
                'integer',
                Rule::exists(TABLE_HOTEL_PRICE_TYPE, 'id')
                    ->where('hotel_id', auth('hms')->user()->current_hotel_id)
            ], 
            'room_ids'          => 'required|array|min:1',
            'room_ids.*'        => [
                'integer',
                Rule::exists(TABLE_HOTEL_ROOM, 'id')
                    ->where('hotel_id', auth('hms')->user()->current_hotel_id)
            ], 
            'type'              => 'required|in:first_night,each_nights,day_of_weeks',
            'start_date'        => 'required|date',
            'end_date'          => 'nullable|date',
            'is_stackable'      => 'required|boolean',
        
            // dynamic validation for `value`
            'value'             => 'required',
        ];
        
        // Thêm điều kiện tùy theo type
        if (request('type') === 'day_of_weeks') {
            $validate['value']                  = 'required|array|min:1';
            $validate['value.*.day_of_week']    = 'required|integer|between:1,7';
            $validate['value.*.value']          = 'required|numeric|min:0|max:100';
        } else {
            $validate['value']                  = 'required|numeric|min:0|max:100';
        }

        return $validate;
    }

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [
          
        ];
    }
    public function withValidator($validator)
    {
       
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }

}
