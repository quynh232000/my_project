<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
        $condHotel              = "required|exists:" . TABLE_HOTEL_HOTEL . ",id";
        $condName               = "required|between:2,255";
        $condStartDate          = "required";
        $condEndDate            = [
            "required",
            function($attribute, $value, $fail){
               if ($this->input('start_date') > $this->input('end_date')) {
                    $fail('Ngày kết thúc phải lớn hơn ngày bắt đầu.');
               }
            }
        ];
        // $condPriceType          = [
        //     "nullable",
        //     function($attribute, $value, $fail){
        //        switch($this->input('all_price_types')){
        //             case 0:
        //                 if ($this->input('price_types') == null) {
        //                     $fail('Vui lòng chọn ít nhất loại giá.');
        //                 }
        //                 break;
        //         }
        //     }
        // ];
        // $condRoomType          = [
        //     "nullable",
        //     function($attribute, $value, $fail){
               
        //        switch($this->input('all_room_types')){
        //             case 0:
        //                 if ($this->input('room_types') == null) {
                           
        //                     $fail('Vui lòng chọn ít nhất loại phòng.');
        //                 }
        //                 break;
        //         }
        //     }
        // ];
        if ($this->input('unlimit') != 0) {
            $condEndDate        = "";
        }

        return [
            'hotel_id'          => $condHotel,
            'name'              => $condName,
            'start_date'        => $condStartDate,
            'end_date'          => $condEndDate,
            // 'all_price_types'   => $condPriceType,
            // 'all_room_types'     => $condRoomType
           
        ];
    }
    public function messages()
    {
        return [
            'hotel_id.required'        => 'Vui lòng chọn khách sạn.',
            'hotel_id.exists'          => 'Khách sạn không tồn tại.',

            'name.required'            => 'Vui lòng nhập tên khuyến mãi.',
            'name.between'             => 'Tên phải có độ dài từ 2 đến 255 ký tự.',

            'start_date.required'      => 'Vui lòng nhập thời gian bắt đầu.',
            'end_date.required'        => 'Vui lòng nhập thời gian kết thúc.'
          
        ];
    }
    public function attributes()
    {
        return [

        ];
    }
}
