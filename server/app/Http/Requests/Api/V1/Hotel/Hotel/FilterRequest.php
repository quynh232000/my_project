<?php

namespace App\Http\Requests\Api\V1\Hotel\Hotel;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilterRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_HOTEL;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $dataTable = [
            'category'      => TABLE_HOTEL_HOTEL_CATEGORY,
            'country'       => TABLE_GENERAL_COUNTRY,
            'province'      => TABLE_GENERAL_PROVINCE,
            'ward'          => TABLE_GENERAL_WARD
        ];


        $validate = [
            'type'          => ["required", "in:" . implode(',', array_keys($dataTable))],
            'adt'           => ['sometimes', 'required', 'numeric', 'min:1'],
            'chd'           => ['sometimes', 'required', 'numeric', 'min:0'],
            'quantity'      => ['sometimes', 'required', 'numeric', 'min:1'],
            'date_start'    => ['sometimes', 'required', 'date', 'after_or_equal:today'],
            'date_end'      => ['sometimes', 'required', 'date', 'after:date_start'],
        ];




        return $validate;
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $hasStart = $this->filled('date_start');
            $hasEnd   = $this->filled('date_end');

            if ($hasStart && $hasEnd) {
                if (!$this->filled('adt')) {
                    $validator->errors()->add('adt', 'Trường adt là bắt buộc khi cả hai trường date_start và date_end đều có.');
                }

                if (!$this->filled('quantity')) {
                    $validator->errors()->add('quantity', 'Trường quantity là bắt buộc khi cả hai trường date_start và date_end đều có.');
                }
            }

            $adult    = (int) $this->input('adt', 0);
            $quantity = (int) $this->input('quantity', 0);

            if ($quantity > $adult) {
                $validator->errors()->add('quantity', 'Số lượng phòng không thể lớn hơn số người lớn.');
            }
        });
    }

    public function attributes(): array
    {
        return [];
    }
    protected function failedValidation($validator)
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }
}
