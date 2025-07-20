<?php

namespace App\Http\Requests\Api\V1\Hms\Customer;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ShowRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HMS_CUSTOMER;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validate = [
            "id"    => [
                        'required',
                        'numeric',
                        "exists:{$this->table},id"
                    ]
        ];
       
        return $validate;
    }

    public function messages()
    {
        return [];
    }
    public function attributes()
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
            'id' => $this->route('customer'),
        ]);
    }
}
