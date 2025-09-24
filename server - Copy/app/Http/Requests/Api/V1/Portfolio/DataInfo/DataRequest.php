<?php

namespace App\Http\Requests\Api\V1\Portfolio\DataInfo;

use App\Traits\ApiRes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class DataRequest extends FormRequest
{
    use ApiRes;
    // private $table            = TABLE_HOTEL_PRICE_TYPE;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validate = [
            'email'              => 'required|email|min:6',
        ];

        return $validate;
    }

    public function messages()
    {
        return [];
    }
    public function attributes()
    {
        return [];
    }
    protected function failedValidation($validator)
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }
}
