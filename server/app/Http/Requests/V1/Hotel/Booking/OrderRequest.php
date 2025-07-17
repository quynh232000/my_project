<?php

namespace App\Http\Requests\Api\V1\Hotel\Booking;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_BOOKING_ORDER;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $data = $this->input('info', []);

        return [
            'info.adt'           => ['required', 'numeric', 'min:1'],
            'info.chd'           => ['sometimes', 'required', 'numeric', 'min:0'],
            'info.quantity'      => ['required', 'numeric', 'min:1'],
            'info.date_start'    => ['sometimes', 'required', 'date', 'after_or_equal:today'],
            'info.date_end'      => ['sometimes', 'required', 'date', 'after:info.date_start'],
            'info.room_id'       => ['required', 'numeric', 'exists:' . TABLE_HOTEL_ROOM . ',id'],
            'info.price_type_id' => [
                'required',
                'numeric',
                Rule::when(
                    (int) data_get($data, 'price_type_id') !== 0,
                    Rule::exists(TABLE_HOTEL_PRICE_TYPE, 'id')
                ),
            ],
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $adult    = (int) $this->input('info.adt', 0);
            $quantity = (int) $this->input('info.quantity', 0);

            if ($quantity > $adult) {
                $validator->errors()->add('info.quantity', 'Số lượng phòng không thể lớn hơn số người lớn.');
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
