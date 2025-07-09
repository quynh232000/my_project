<?php

namespace App\Http\Requests\Api\V1\Hms\Album;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_ALBUMN;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'slug'              => 'sometimes|string|max:255',
            'type'              => 'required|in:room_type,hotel',
            'images'            => 'required|array|max:10',
            'images.*.image'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'images.*.label_id' => 'required|integer|exists:'.TABLE_HOTEL_ATTRIBUTE.',id',
        ];
        if(request()->input('type') == 'room_type'){
        $validate   = [
                        ... $validate,
                        'room_id' => [
                                        'required',
                                        'integer',
                                        Rule::exists(TABLE_HOTEL_ROOM, 'id')
                                            ->where('hotel_id', auth('hms')->user()->current_hotel_id)
                                    ]
                    ];
        }

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
