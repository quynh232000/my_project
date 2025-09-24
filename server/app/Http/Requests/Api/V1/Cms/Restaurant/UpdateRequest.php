<?php

namespace App\Http\Requests\Api\V1\Cms\Restaurant;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_CMS_RESTAURANT;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string|max:255',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'time_open'   => 'nullable|string|max:50',
            'time_close'  => 'nullable|string|max:50',
            'type'        => 'required|in:cafe,restaurant,buffet',
            'capacity'    => 'nullable|integer|min:1',
            'branch'      => 'nullable|string|max:255',
            'currency'    => 'required|string|max:10',
            'plan_id'     => 'required|integer|exists:'.TABLE_CMS_PLAN.',id',
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
            'id' => $this->route('restaurant'),
        ]);
    }
}
