<?php

namespace App\Http\Requests\Api\V1\Cms\MenuCategory;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_CMS_MENU_CATEGORY;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'name'              => 'required|string|max:255|unique:' . $this->table.',name',
            'description'       => 'required|string',
            'status'             => 'required|in:active,inactive',
            'priority'          => 'nullable|integer|min:1',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'restaurant_id'      => 'sometimes|integer|exists:'.TABLE_CMS_RESTAURANT.',id',
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
            'id' => $this->route('menu_category'),
        ]);
    }
}
