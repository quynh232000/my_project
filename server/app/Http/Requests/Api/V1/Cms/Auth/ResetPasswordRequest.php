<?php

namespace App\Http\Requests\Api\V1\Cms\Auth;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_CMS_USER;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'     => 'required|email|exists:' . $this->table . ',email',
            'password'  => 'required|string|confirmed|min:6',
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
