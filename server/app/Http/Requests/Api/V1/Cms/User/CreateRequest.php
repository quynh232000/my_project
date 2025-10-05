<?php

namespace App\Http\Requests\Api\V1\Cms\User;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_CMS_USER;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string',
            'email'     => 'required|string|email|unique:'.$this->table.',email',
            'password'  => 'required|string',
            'avatar'    => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:2048',
            'role_ids'       => 'sometimes|array',
            'role_ids.*'     => [
                'string',
                Rule::exists(TABLE_CMS_ROLE, 'id'),
            ],

            'permission_ids'   => 'sometimes|array',
            'permission_ids.*' => [
                'string',
                Rule::exists(TABLE_CMS_PERMISSION, 'id'),
            ],
        ];

        return $validate;
    }

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }
    public function withValidator($validator) {}
    protected function failedValidation($validator)
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }
}
