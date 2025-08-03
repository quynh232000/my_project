<?php

namespace App\Http\Requests\Api\V1\Hotel\HotelCategory;

use App\Traits\ApiResponse;
use DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ShowRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_HOTEL_CATEGORY;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $dataTable  = [
            'country'       => TABLE_GENERAL_COUNTRY,
            'province'      => TABLE_GENERAL_PROVINCE,
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
        ];

        return $validate;
    }
    public function attributes(): array
    {
        return [];
    }
    protected function failedValidation($validator)
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'slug'          => $this->route('hotel_category'),
        ]);
    }
}
