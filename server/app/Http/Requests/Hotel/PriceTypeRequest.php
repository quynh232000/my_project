<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class PriceTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->id;
        $condName                   = "bail|required|between:2,255";
        $condHotel                  = "bail|required|exists:" . TABLE_HOTEL_HOTEL . ",id";
        $condStatus                 = "bail|required|in:active,inactive";
        $condRoomTypes              = "bail|required";
        $condAdtfees                = "bail|min:0";
        $condBookingDateMin         = "bail|nullable|numeric|min:0";
        $condBookingDateMax         = "bail|nullable|numeric|min:0";
        $condNightsNumberMin        = "bail|nullable|numeric|min:0";
        $condNightsNumberMax        = "bail|nullable|numeric|min:0";
        if ($this->input('all_room_types') == 1) {
            $condRoomTypes = "";
        }
       
        return [
            'name'                  => $condName,
            'hotel_id'              => $condHotel,
            'room_type_id'            => $condRoomTypes,
            'adt_fees'              => $condAdtfees,
            'booking_date_min'      => $condBookingDateMin,
            'booking_date_max'      => $condBookingDateMax,
            'nights_number_min'     => $condNightsNumberMin,
            'nights_number_max'     => $condNightsNumberMax,
            'status'                => $condStatus,
        ];
    }
    public function messages()
    {
        return [
            'name.required'         => 'Vui lòng nhập tên loại giá.',
            'name.between'          => 'Tiêu đề phải có độ dài từ :min đến :max ký tự.',
            
            'hotel_id.required'     => 'Vui lòng chọn khách sạn.',
            'hotel_id.exists'       => 'Khách sạn không tồn tại.',

            'adt_fees.min'          => 'Phí không nhỏ hơn :min.',

            'room_type_id.required' => 'Vui lòng chọn loại phòng.',

            'booking_date_min.min' => 'Ngày đặt trước không nhỏ hơn :min',
            'booking_date_max.min' => 'Ngày đặt trước không nhỏ hơn :min',

            'nights_number_min.min' => 'Số đêm không nhỏ hơn :min',
            'nights_number_max.min' => 'Số đêm không nhỏ hơn :min',

         
        ];
    }
    public function attributes()
    {
        return [
           
        ];
    }
}
