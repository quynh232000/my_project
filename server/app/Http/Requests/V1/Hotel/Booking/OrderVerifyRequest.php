<?php

namespace App\Http\Requests\Api\V1\Hotel\Booking;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class OrderVerifyRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_BOOKING_ORDER;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'       => ['required',  'exists:' . $this->table . ',code'],
        ];
    }
    public function withValidator($validator)
    {
      
    }

    public function attributes(): array
    {
        return [];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }
}
