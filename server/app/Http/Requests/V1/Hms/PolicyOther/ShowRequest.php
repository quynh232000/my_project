<?php

namespace App\Http\Requests\Api\V1\Hms\PolicyOther;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ShowRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_POLICY_OTHER;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $table = $this->table;
        return [
            'slug'     => [
                            "required",
                            Rule::exists(TABLE_HOTEL_POLICY_SETTING, 'slug'),
                        ]
        ];
    }
    public function attributes(): array
    {
        return [];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }
    
    public function validationData(): array
    {
            return array_merge($this->all(), [
                'slug' => $this->route('policy_other'),
            ]);
    }

}
