<?php

namespace App\Http\Requests\Api\V1\Hotel\Hotel;

use App\Traits\ApiResponse;
use DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

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
        $dataTable  = [
            'country'       => TABLE_GENERAL_COUNTRY,
            'city'          => TABLE_GENERAL_CITY,
            'district'      => TABLE_GENERAL_DISTRICT,
            'ward'          => TABLE_GENERAL_WARD,
            'chain'         => TABLE_HOTEL_CHAIN
        ];
        $type       = request()->input('type');
        $validate   = [
            'slug'          => [
                'required',
                function ($attribute, $value, $fail) use ($type, $dataTable) {
                    // 1. Kiểm tra trong bảng hotel_category
                    $existsInCategory = DB::table(TABLE_HOTEL_HOTEL_CATEGORY)
                        ->where('slug', $value)
                        ->where('type_location', $type)
                        ->exists();

                    // 2. Kiểm tra trong bảng địa lý tương ứng (nếu có)
                    $table          = $dataTable[$type] ?? null;
                    $existsInGeo    = $table
                        ? DB::table($table)->where('slug', $value)->exists()
                        : false;

                    if (!$existsInCategory && !$existsInGeo) {
                        $fail("Slug không tồn tại trong danh mục, chain hoặc địa chỉ hành chính tương ứng.");
                    }
                }
            ],
            'type'          => ["required", "in:country,city,district,ward,chain"],
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
                    $validator->errors()->add('adt', 'Số lượng người lớn là bắt buộc khi có ngày bắt đầu và ngày kết thúc.');
                }

                if (!$this->filled('quantity')) {
                    $validator->errors()->add('quantity', 'Vui lòng chọn số lượng ngày ở.');
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
