<?php

namespace App\Http\Requests\Api\V1\Hms\PolicyChildren;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_POLICY_CHILDREN;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'policies'                  => 'nullable|array',
            'policies.*.id'             => [
                                            'sometimes', // có thể có hoặc không
                                            'integer',
                                            Rule::exists($this->table, 'id'), // nếu có thì phải tồn tại
                                        ],
            'policies.*.age_from'       => 'required|numeric|min:0|max:17',
            'policies.*.age_to'         => 'required|numeric|min:0|max:17',
            'policies.*.fee_type'       => 'required|in:free,charged,limit',
            'policies.*.quantity_child' => '',
            'policies.*.meal_type'      => 'required|string|in:ro,bb',
        ];

        return $validate;
    }

    public function messages(): array
    {
        return [
            'policies.array'                    => 'Trường policies phải là một mảng.',

            'policies.*.id.exists'              => 'ID không tồn tại trong hệ thống.',
            'policies.*.age_from.required'      => 'Vui lòng nhập đẩu đủ thông tin',
            'policies.*.age_to.required'        => 'Vui lòng nhập đẩu đủ thông tin',
            'policies.*.quantity_child'         => 'nullable|numeric',

            'policies.*.meal_type.required'     => 'Vui lòng nhập đẩu đủ thông tin',
            'policies.*.meal_type.in'           => 'Trường meal_type phải là RO hoặc BB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'policies'                      => 'Danh sách chính sách',
            'policies.*.age_from'           => 'Tuổi từ',
            'policies.*.age_to'             => 'Tuổi đến',
            'policies.*.meal_type'          => 'RO/BB',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach ($this->input('policies', []) as $index => $policy) {
                if (($policy['fee_type'] ?? null) == 'limit') {
                    if(empty($policy['quantity_child'])){
                        $validator->errors()->add(
                            "policies.$index.quantity_child",
                            "Vui lòng nhập số lượng trẻ em."
                        );
                    }
                    if(empty($policy['fee']) || $policy['fee'] <= 0){
                        $validator->errors()->add(
                            "policies.$index.fee",
                            "Vui lòng nhập phí phụ thu."
                        );
                    }
                }else if(($policy['fee_type'] ?? null) == 'charged' && (empty($policy['fee']??'')|| $policy['fee'] <=0)){
                    $validator->errors()->add(
                        "policies.$index.fee",
                        "Vui lòng nhập phí phụ thu."
                    );
                }else if(($policy['fee_type'] ?? null) == 'charged' && (empty($policy['fee'])|| $policy['fee'] <=0)){
                    $validator->errors()->add(
                        "policies.$index.fee",
                        "Vui lòng nhập phí phụ thu."
                    );
                }
            }
        });
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }

}
