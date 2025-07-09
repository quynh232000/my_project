<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRegisterRequest extends FormRequest
{
    private $table = TABLE_HOTEL_PARTNER_REGISTER;

    
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
      
        return [
            'status'    => "required|in:approved,rejected",
        ];
    }

    public function messages()
    {
        return [
            'status.required'                 => 'Vui lòng chọn trạng thái xử lý.',
            'status.in'                       => 'Trạng thái không hợp lệ.'
        ];
    }
    public function attributes()
    {
        return [
           
        ];
    }
}
