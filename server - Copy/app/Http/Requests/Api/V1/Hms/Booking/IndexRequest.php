<?php

namespace App\Http\Requests\Api\V1\Hms\Booking;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
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
                'code'          => ['nullable', 'string', 'max:50'],             
                'created_at'    => ['nullable', 'date'],                        
                'date_from'     => ['nullable', 'date'],
                'date_to'       => ['nullable', 'date', 'after_or_equal:date_from'],
                'price_type_id' => ['nullable', 'integer'],
                'hotel_id'      => ['nullable', 'integer'],
                'status'        => ['nullable', 'integer'],   
        ];
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
