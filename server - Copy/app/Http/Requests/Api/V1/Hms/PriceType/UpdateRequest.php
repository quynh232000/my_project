<?php

namespace App\Http\Requests\Api\V1\Hms\PriceType;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_PRICE_TYPE;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validate = [
            "id"                =>  ['nullable',
                                        'numeric',
                                        Rule::exists($this->table, 'id')->where(function ($query) {
                                            $query->where(['hotel_id' => auth('hms')->user()->current_hotel_id]);
                                        })
                                    ],
            'name'              => 'required|string|max:255',
            'rate_type'         => 'required', 
            'room_ids'         => 'required|array|min:1',
            'room_ids.*'       => 'integer|exists:'.TABLE_HOTEL_ROOM.',id',
    
            'policy_cancel_id'  => 'nullable|integer|exists:'.TABLE_HOTEL_POLICY_CANCELLATION.',id',

            'policy_children'                  => 'nullable|array',
            'policy_children.*.id'             => [
                                                    'sometimes', // có thể có hoặc không
                                                    'integer',
                                                    Rule::exists(TABLE_HOTEL_POLICY_CHILDREN, 'id'), // nếu có thì phải tồn tại
                                                ],
            'policy_children.*.age_from'       => 'required|numeric|min:0|max:17',
            'policy_children.*.age_to'         => 'required|numeric|min:0|max:17',
            'policy_children.*.fee_type'       => 'required|in:free,charged,limit',
            'policy_children.*.quantity_child' => '',
            'policy_children.*.meal_type'      => 'required|string|in:ro,bb',
            
            'date_min'          => 'required|integer|min:1',
            'date_max'          => 'required|integer|gte:date_min',
    
            'night_min'         => 'required|integer|min:1',
            'night_max'         => 'required|integer|gte:night_min',
        ];
       
        return $validate;
    }

    public function messages()
    {
        return [
            'policy_children.array'                    => 'Trường policy_children phải là một mảng.',

            'policy_children.*.id.exists'              => 'ID không tồn tại trong hệ thống.',
            'policy_children.*.age_from.required'      => 'Vui lòng nhập đẩu đủ thông tin',
            'policy_children.*.age_to.required'        => 'Vui lòng nhập đẩu đủ thông tin',
            'policy_children.*.quantity_child'         => 'nullable|numeric',

            'policy_children.*.meal_type.required'     => 'Vui lòng nhập đẩu đủ thông tin',
            'policy_children.*.meal_type.in'           => 'Trường meal_type phải là RO hoặc BB.',
        ];
    }
    public function attributes()
    {
        return [
            'policy_children'                      => 'Danh sách chính sách',
            'policy_children.*.age_from'           => 'Tuổi từ',
            'policy_children.*.age_to'             => 'Tuổi đến',
            'policy_children.*.meal_type'          => 'RO/BB',
        ];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
}
