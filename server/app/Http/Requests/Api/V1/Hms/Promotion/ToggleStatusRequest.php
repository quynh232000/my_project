<?php

namespace App\Http\Requests\Api\V1\Hms\Promotion;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ToggleStatusRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_PROMOTION;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'                  => [
                                        "required",
                                        Rule::exists($this->table, 'id')->where(function ($query) {
                                            $query->where('hotel_id', auth('hms')->user()->current_hotel_id);
                                        }),
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
            'id' => $this->route('promotion'),
        ]);
    }
}
