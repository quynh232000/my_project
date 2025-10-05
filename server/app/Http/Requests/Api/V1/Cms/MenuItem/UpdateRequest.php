<?php

namespace App\Http\Requests\Api\V1\Cms\MenuItem;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_CMS_MENU_ITEM;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
             'restaurant_id'      => 'sometimes|integer|exists:'.TABLE_CMS_RESTAURANT.',id',
           // thông tin menu item
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'priority'    => 'sometimes|nullable|integer|min:1',
            'status'      => 'sometimes|nullable|in:active,inactive',
            'image'       => 'sometimes|nullable|string',
            'category_id' => 'sometimes|integer|exists:'.TABLE_CMS_MENU_CATEGORY.',id',
            'base_price'  => 'sometimes|numeric|min:0',
            // options
            'options'                 => 'sometimes|array',
            'options.*.id'            => 'sometimes|integer|exists:'.TABLE_CMS_MENU_OPTION.',id',
            'options.*.name'          => 'sometimes|required|string|max:255',
            'options.*.type'          => 'sometimes|required|in:single_choice,multi_choice',
            'options.*.required'      => 'sometimes|boolean',
            'options.*.priority'      => 'sometimes|nullable|integer|min:1',
            'options.*.status'        => 'sometimes|in:active,inactive',

            // option values
            'options.*.values'              => 'sometimes|array',
            'options.*.values.*.id'         => 'sometimes|integer|exists:'.TABLE_CMS_MENU_OPTION_VALUE.',id',
            'options.*.values.*.name'       => 'sometimes|required|string|max:255',
            'options.*.values.*.extra_price'=> 'sometimes|nullable|numeric|min:0',

            // prices
            'prices'                 => 'sometimes|array',
            'prices.*.id'            => 'sometimes|integer|exists:'.TABLE_CMS_MENU_PRICE.',id',
            'prices.*.type'          => 'sometimes|required|in:default,time_based,special',
            'prices.*.price'         => 'sometimes|required|numeric|min:0',
            'prices.*.valid_from'      => 'sometimes|nullable',
            'prices.*.valid_to'        => 'sometimes|nullable',
            'prices.*.status'        => 'sometimes|in:active,inactive',
        ];

        return $validate;
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Tên món không được bỏ trống khi cập nhật.',
            'options.*.name.required' => 'Tên tuỳ chọn không được bỏ trống khi cập nhật.',
            'options.*.values.*.name.required' => 'Tên lựa chọn trong option không được bỏ trống khi cập nhật.',
            'prices.*.name.required' => 'Tên giá không được bỏ trống khi cập nhật.',
            'prices.*.price.required'=> 'Giá không được bỏ trống khi cập nhật.',
        ];
    }

    public function attributes(): array
    {
        return [];
    }
    public function withValidator($validator) {}
    protected function failedValidation($validator)
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('menu_item'),
        ]);
    }
}
