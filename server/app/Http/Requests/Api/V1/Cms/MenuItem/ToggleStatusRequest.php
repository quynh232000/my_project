<?php

namespace App\Http\Requests\Api\V1\Cms\MenuItem;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ToggleStatusRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_CMS_MENU_ITEM;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
             'restaurant_id'      => 'sometimes|integer|exists:'.TABLE_CMS_RESTAURANT.',id',
            'id'                  => [
                "required",
                Rule::exists($this->table, 'id')
            ]
        ];
    }
    public function attributes(): array
    {
        return [];
    }
    protected function failedValidation($validator)
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
    public function validationData()
    {
        return array_merge($this->all(), [
            // 'id' => $this->route('menu_item'),
        ]);
    }
}
