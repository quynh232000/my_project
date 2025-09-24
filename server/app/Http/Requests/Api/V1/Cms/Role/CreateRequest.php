<?php

namespace App\Http\Requests\Api\V1\Cms\Role;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_CMS_ROLE;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'status'             => 'required|in:active,inactive',
            'permission_ids'   => 'sometimes|array',
            // 'permission_ids.*' => 'string',
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
