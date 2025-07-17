<?php

namespace App\Http\Requests\Api\V1\Hms\Auth;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email'     => "required|string|email|max:255|exists:{$this->table},email",
            'password'  => 'required|string|min:6|max:255',
        ];
    }

    public function messages()
    {
        return [
            'email.required'      => 'Vui lòng nhập email.',
            'email.email'         => 'Email không đúng định dạng.',
            'email.max'           => 'Email không được vượt quá 255 ký tự.',
            'email.exists'        => 'Email không tồn tại trong hệ thống.',
            'password.required'   => 'Vui lòng nhập mật khẩu.',
            'password.min'        => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.max'        => 'Mật khẩu không được vượt quá 255 ký tự.',
        ];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
}
