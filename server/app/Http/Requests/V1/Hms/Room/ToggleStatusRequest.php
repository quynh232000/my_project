<?php

namespace App\Http\Requests\Api\V1\Hms\Room;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ToggleStatusRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_ROOM;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'status'        => 'required|in:active,inactive',
            'room_ids'      => 'required|array|min:1',
            'room_ids.*'    => 'integer|exists:'.$this->table.',id',
        ];

        return $validate;
    }

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [
          
        ];
    }
    public function withValidator($validator)
    {
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }

}
