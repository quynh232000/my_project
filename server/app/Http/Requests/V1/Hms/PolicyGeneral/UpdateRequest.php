<?php

namespace App\Http\Requests\Api\V1\Hms\PolicyGeneral;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_POLICY_GENERAL;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'policies'                      => 'nullable|array',
            'policies.*.policy_setting_id'  => 'required|exists:' . TABLE_HOTEL_POLICY_SETTING . ',id',
            'policies.*.is_allow'           => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'policies.array'                        => 'Trường policies phải là một mảng.',

            'policies.*.policy_setting_id.required' => 'Vui lòng chọn chính sách.',
            'policies.*.policy_setting_id.exists'   => 'Chính sách được chọn không hợp lệ.',

            'policies.*.is_allow.required'          => 'Trường is_allow là bắt buộc.',
            'policies.*.is_allow.boolean'           => 'Trường is_allow phải là true hoặc false.',
        ];
    }

    public function attributes(): array
    {
        return [
            'policies'                      => 'danh sách chính sách',
            'policies.*.policy_setting_id'  => 'chính sách',
            'policies.*.is_allow'           => 'trạng thái cho phép',
        ];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
}
