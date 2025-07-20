<?php

namespace App\Http\Requests\Api\V1\Hms\PolicyOther;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_POLICY_OTHER;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            "slug"     => "required|exists:".TABLE_HOTEL_POLICY_SETTING.",slug",
        ];

        if(isset(request()->is_active) && request()->is_active == false){
            return $validate;
        }
        switch (request()->slug) {
            case 'serves-breakfast':
                $validate = [
                    ...$validate,
                    'settings'                              => ['required', 'array'],
                    'settings.time_from'                    => ['required', 'date_format:H:i'],
                    'settings.time_to'                      => ['required', 'date_format:H:i'],
                    'settings.breakfast_type'               => ['required', 'integer',"exists:".TABLE_HOTEL_ATTRIBUTE.",id"],
                    'settings.serving_type'                 => ['required', 'integer',"exists:".TABLE_HOTEL_ATTRIBUTE.",id"],

                    'settings.extra_breakfast'              => ['nullable', 'array'],
                    'settings.extra_breakfast.*.age_from'   => ['required', 'integer', 'min:0'],
                    'settings.extra_breakfast.*.age_to'     => ["nullable", 'integer', 'gt:settings.extra_breakfast.*.age_from'],
                    'settings.extra_breakfast.*.fee_type'   => ['required', Rule::in(['free', 'charged'])],
                    'settings.extra_breakfast.*.fee'        => ['required', 'numeric', 'min:0'],

                ];
               
                break;
            case 'minimum-check-in-age':
                $validate = [
                    ...$validate,
                    'settings'                              => ['required', 'array'],
                    'settings.age'                          => ['required', 'numeric', 'min:0','max:100'],

                    'settings.doccument_require'            => ['required', 'array', 'min:1'],
                    'settings.doccument_require.*'          => ['string', 'in:cccd,passport,driver_license'],

                    'settings.adult_require'                => ['required', 'array', 'min:1'],
                    'settings.adult_require.*'              => ['string', 'in:parent,legal_guardian,relative_over_18'],

                    'settings.accompanying_adult_proof'     => ['required', 'boolean'],
                ];

                break;
                case 'deposit-policy':
                    $validate = [
                        ...$validate,
                        'settings'                          => ['required', 'array'],
                        'settings.type_deposit'             => ['required', Rule::in(['fixed', 'percent'])],
                        'settings.amount'                   => ['required', 'numeric', 'min:0'],

                        'settings.method_deposit'           => ['required', 'array', 'min:1'],
                        'settings.method_deposit.*'         => ['string', Rule::in(['cash', 'credit_card', 'banking'])],

                    ];
                    break;
            default:
                # code...
                break;
        }

        return $validate;
    }

    public function messages(): array
    {
        return [
            'settings.extra_breakfast.*.age_to.gt'  => 'Tuổi kết thúc phải lớn hơn tuổi bắt đầu',
            'settings.doccument_require.*.in'       => 'Tài liệu không hợp lệ (chỉ chấp nhận: cccd, passport, driver_license).',
            'settings.adult_require.*.in'           => 'Yêu cầu người lớn không hợp lệ (chỉ chấp nhận: parent, legal_guardian, relative_over_18).',
            'settings.type_deposit.in'              => 'Loại đặt cọc không hợp lệ (fixed hoặc percent).',
            'settings.method_deposit.*.in'          => 'Phương thức đặt cọc không hợp lệ (cash, credit_card, banking).',
        ];
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
