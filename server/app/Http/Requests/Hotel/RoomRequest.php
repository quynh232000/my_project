<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    private $table = TABLE_HOTEL_ROOM;
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
        // $condRoom               = "required|between:1,50";
        $condBedType            = "required"; 
        $condGuestQuantity      = "required|numeric";
        $condGuestQuantity      = "required|numeric";
        $condPrice              = "required";
        $condBreakfast          = "in:y,n";
        $condStatus             = "required|in:available,booked,maintenance";

        return [
            // 'number'                => $condRoom,
            'bed_type'              => $condBedType,
            'guest_quantity'        => $condGuestQuantity,
            'room_quantity'         => $condGuestQuantity,
            'breakfast'             => $condBreakfast,
            'price'                 => $condPrice
            // 'status'                => $condStatus,
            
        ];
    }
    public function messages()
    {
        return [
            // 'number.required'           => 'Vui lòng nhập số phòng.',
            // 'number.between'            => 'Tên phòng phải có độ dài từ 1 đến 50 ký tự.',
            
            'price.required'            => 'Vui lòng nhập giá phòng',

            'bed_type.required'         => 'Vui lòng chọn loại giường',

            'guest_quantity.required'   => 'Vui lòng nhập số lượng khách',
            'guest_quantity.numeric'    => 'Số lượng khách phải là số',

            'room_quantity.required'    => 'Vui lòng nhập số lượng phòng',
            'room_quantity.numeric'     => 'Số lượng phòng phải là số',

            'breakfast.in'              => 'Tuỳ chọn không hợp lệ',

            'status.required'           => 'Vui lòng chọn trạng thái.',
            'status.in'                 => 'Trạng thái không hợp lệ.',
        
        ];
    }

    public function attributes()
    {
        return [
            
        ];
    }
}
