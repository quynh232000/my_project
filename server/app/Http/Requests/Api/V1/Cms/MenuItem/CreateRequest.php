<?php

namespace App\Http\Requests\Api\V1\Cms\MenuItem;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'nullable|integer|min:1',
            'status'      => 'nullable|in:active,inactive',
            'image'       => 'nullable|string',
            'category_id' => 'required|integer|exists:'.TABLE_CMS_MENU_CATEGORY.',id',
            'base_price'  => 'required|numeric|min:0',


            // options
            'options'                 => 'nullable|array',
            'options.*.name'          => 'required_with:options|string|max:255',
            'options.*.type'          => 'required_with:options|in:single_choice,multi_choice',
            'options.*.required'      => 'nullable|boolean',
            'options.*.priority'      => 'nullable|integer|min:1',
            'options.*.status'        => 'nullable|in:active,inactive',

            // option values
            'options.*.values'              => 'nullable|array',
            'options.*.values.*.name'       => 'required_with:options.*.values|string|max:255',
            'options.*.values.*.extra_price'=> 'nullable|numeric|min:0',

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
             'name.required'               => 'Tên món là bắt buộc.',
            'options.*.name.required_with'=> 'Tên tuỳ chọn là bắt buộc khi thêm option.',
            'options.*.type.in'           => 'Loại tuỳ chọn chỉ được single_choice hoặc multi_choice.',
            'options.*.values.*.name.required_with' => 'Tên lựa chọn trong option là bắt buộc.',
            'prices.*.name.required_with' => 'Tên giá là bắt buộc khi thêm giá.',
            'prices.*.price.required_with'=> 'Giá là bắt buộc khi thêm giá.',
        ];
    }

    public function attributes(): array
    {
        return [];
    }
    public function withValidator($validator) {}
    protected function failedValidation($validator)
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }
}
