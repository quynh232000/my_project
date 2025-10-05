<?php

namespace App\Http\Requests\Api\V1\Hms\PolicyCancellation;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_POLICY_CANCELLATION;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            "id"                        =>  ['nullable',
                                                'numeric',
                                                Rule::exists($this->table, 'id')->where(function ($query) {
                                                    $query->where(['hotel_id' => auth('hms')->user()->current_hotel_id, 'is_global' => 'inactive']);
                                                })
                                            ],
            'is_global'                 => "required|boolean",
            "status"                    => "required|in:active,inactive",
            'name'                      => '',
            'code'                      => '',

            'policy_rules'              => 'nullable|array',
            'policy_rules.*.id'         => [
                                            'sometimes', // có thể có hoặc không
                                            'integer',
                                            Rule::exists(TABLE_HOTEL_POLICY_CANCEL_RULE, 'id')
                                            ->where(function ($query) {
                                                $query->where('policy_cancel_id', $this->input('id'));
                                            }), // nếu có thì phải tồn tại
                                        ],
            'policy_rules.*.day'        => 'required|numeric|min:0|max:100',
            'policy_rules.*.fee_type'   => 'required|in:free,percent_price',
            'policy_rules.*.fee'        => "nullable|numeric|min:0|max:100",
        ];

        if(!request()->boolean('is_global')){
            $validate['name']           = 'required';
            $validate['code']           = [
                                            'required',
                                            Rule::unique($this->table, 'code')
                                                ->ignore(request()->id), // bỏ qua chính nó nếu đang update
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
            'policy_rules'                  => 'Danh sách quy tắc',
            'policy_rules.*.day'            => 'Ngày vắng mặt',
            'policy_rules.*.fee_type'       => 'Loại phí',
            'policy_rules.*.fee'            => 'Phí',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->input('id');
            $isGlobal = $this->boolean('is_global'); // đảm bảo lấy giá trị boolean chuẩn

            if (!empty($id) && $isGlobal) {
                $validator->errors()->add('is_global', 'Trường is_global phải là false để cập nhật chính sách riêng.');
            }
        });
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }

}
