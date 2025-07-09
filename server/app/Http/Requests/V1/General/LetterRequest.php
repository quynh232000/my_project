<?php

namespace App\Http\Requests\Api\V1\General;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class LetterRequest extends FormRequest
{
    private $table            = TABLE_GENERAL_LETTER;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique($this->table, 'email')->where(function ($query) {
                    return $query->where('domain', $this->input('domain'));
                }),
            ],
            'domain' => ['required', 'string'],
        ];
    }

    private function getMessages($lang = 'en-us'){
         $message =    [
            'en-us' =>[
                'email.required'    => 'Please enter an email address.',
                'email.email'       => 'Invalid email address.',
                'email.unique'      => 'This email is already in use.',
                'domain.required'   => 'Please select a domain name.',
            ],
            'vi-vn' =>[
                'email.required'    => 'Vui lòng nhập địa chỉ email.',
                'email.email'       => 'Địa chỉ email không hợp lệ.',
                'email.unique'      => 'Email này đã được sử dụng.',
                'domain.required'   => 'Vui lòng chọn domain.',
            ],
        ];
        return isset($message[$lang]) ? $message[$lang] : $message['en-us'];
    }


    public function messages()
    {
        return $this->getMessages(request()->input('lang'));
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
