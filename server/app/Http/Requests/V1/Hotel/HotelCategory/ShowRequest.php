<?php

namespace App\Http\Requests\Api\V1\Hotel\HotelCategory;

use App\Traits\ApiResponse;
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
        $dataTable = [
            'category'      => TABLE_HOTEL_HOTEL_CATEGORY,
            'country'       => TABLE_GENERAL_COUNTRY,
            'city'          => TABLE_GENERAL_CITY,
            'district'      => TABLE_GENERAL_DISTRICT,
            'ward'          => TABLE_GENERAL_WARD
        ];


        $validate = [
            'type'          => ["required","in:" . implode(',', array_keys($dataTable))]
        ];

        if(request()->type ?? false){
            $validate['id'] = ['required','exists:'.$dataTable[request()->type].',id'];
        }

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
            'id'          => $this->route('hotel_category'),
        ]);
    }

}
