<?php

namespace App\Http\Requests\Api\V1\Cms\Permission;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_CMS_PERMISSION;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'name'              => 'required|string|max:255',
            'route_name'        => 'required|string',
            'uri'               => 'required|string',
            'method'            => 'required|string',
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
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('permission'),
        ]);
    }
}
