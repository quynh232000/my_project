<?php

namespace App\Http\Requests\Api\V1\Hms\Service;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IndexRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_SERVICE;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type'     => "required|in:hotel,room",
        ];
    }

    public function messages()
    {
      return [];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
}
