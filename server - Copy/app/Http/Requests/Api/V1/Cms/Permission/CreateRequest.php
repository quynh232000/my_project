<?php

namespace App\Http\Requests\Api\V1\Cms\Permission;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_CMS_PERMISSION;
    public function authorize()
    {
        return true;
    }

   public function rules(): array
    {
        return [
            'data'                     => 'required|array',
            'data.*.name'              => 'required|string|max:255',
            'data.*.route_name'        => 'required|string',
            'data.*.uri'               => 'required|string',
            'data.*.method'            => 'required|string',
        ];
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
