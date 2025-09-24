<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class PriorityRequest extends FormRequest
{
    private $table = TABLE_HOTEL_PRIORITY;
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->id;

        $validate = [
            'hotel_id'      => "bail|required|exists:".TABLE_HOTEL_HOTEL.",id",
            'priority'      => "bail|required|integer|min:0|max:9999",
            'status'        => "bail|required|in:active,inactive",
        ];

        $map = [
            'is_country'    => 'country_id',
            'is_city'       => 'city_id',
            'is_district'   => 'district_id',
            'is_ward'       => 'ward_id',
        ];

        foreach ($map as $flag => $field) {
            if ($this->has($flag)) {
                $validate[$field] = 'required';
            }
        }
        
        return $validate;
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $fields         = [
                                'category_id',
                                'address',
                                'country_id',
                                'city_id',
                                'district_id',
                                'ward_id',
                            ];

            $hasAtLeastOne  = false;

            foreach ($fields as $field) {
                if (!is_null($this->input($field)) && $this->filled($field)) {
                    $hasAtLeastOne = true;
                    break;
                }
            }

            if (!$hasAtLeastOne) {
                foreach ($fields as $field) {
                    $validator->errors()->add($field, 'Ít nhất phải có một trường được chọn.');
                }
            }
        });
        
    }
    public function messages()
    {
        return [];
    }
}
