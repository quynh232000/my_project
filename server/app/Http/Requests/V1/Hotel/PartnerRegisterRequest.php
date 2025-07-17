<?php

namespace App\Http\Requests\Api\V1\Hotel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PartnerRegisterRequest extends FormRequest
{
    private $table            = TABLE_HOTEL_PARTNER_REGISTER;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'     => "required|string|max:255",
            'full_name' => "required|string|max:255",
            'email'     => "required|string|email|max:255|unique:".$this->table.",email",
            'phone'     => "required|string|regex:/^[0-9]{10,15}$/",
            'address'   => "required|string|max:500"
        ];
    }

    public function messages()
    {
        return [
            'title.required'      => 'Vui lòng nhập tên khách sạn.',
            'title.max'           => 'Tên khách sạn không được vượt quá 255 ký tự.',
            'full_name.required'  => 'Vui lòng nhập họ tên.',
            'full_name.max'       => 'Họ tên không được vượt quá 255 ký tự.',
            'email.required'      => 'Vui lòng nhập email.',
            'email.email'         => 'Email không đúng định dạng.',
            'email.max'           => 'Email không được vượt quá 255 ký tự.',
            'email.unique'        => 'Email này đã được đăng ký trước đó.',
            'phone.required'      => 'Vui lòng nhập số điện thoại.',
            'phone.regex'         => 'Số điện thoại không hợp lệ. Chỉ chấp nhận số từ 10 đến 15 chữ số.',
            'address.required'    => 'Vui lòng nhập địa chỉ khách sạn.',
            'address.max'         => 'Địa chỉ không được vượt quá 500 ký tự.'
        ];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException(response()->json([
            'status'        => false,
            'message'       => 'Dữ liệu không hợp lệ!',
            'errors'        => $validator->errors(),
            'status_code'   => 422
        ], 422));
    }
}
