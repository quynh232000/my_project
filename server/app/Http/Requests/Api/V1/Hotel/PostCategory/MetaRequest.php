<?php

namespace App\Http\Requests\Api\V1\Hotel\PostCategory;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MetaRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_POST_CATEGORY;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'slug'          => [
                "required",
                Rule::exists($this->table, 'slug')->where(function ($query) {
                    $query->where('status', 'active');
                })
            ],
        ];

        return $validate;
    }

    public function attributes(): array
    {
        return [];
    }
    protected function failedValidation($validator)
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }
}
