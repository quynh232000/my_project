<?php

namespace App\Http\Requests\Api\V1\Hms\Auth;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyResetCodeRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HMS_CUSTOMER;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'     => 'required|email|exists:'.$this->table.',email',
            'code'      => 'required|string|min:4|max:4',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
}
