<?php

namespace App\Http\Requests\Travel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    public function rules()
    {


        return [
            'title' => 'required',
            'thumnail' => 'required|image',
            'images' => 'required',
            'type' => 'required',
            'category' => 'required',
            'price' => 'required',
            'price_child' => 'required',
            'price_baby' => 'required',
            'percent_sale' => 'required',
            'additional_fee' => 'required',
            "province_start_id" => 'required',
            "province_end_id" => 'required',
            'number_of_day' => 'required',
            'tour_pakage' => 'required',
            'quantity' => 'required',
            'date_start' => 'required',
            'time_start' => 'required',
            'transportation' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required'                 => 'Vui lòng nhập tên.',
            'name.between'                  => 'Tên phải có độ dài từ 2 đến 255 ký tự.',
            'slug.required'                 => 'Vui lòng nhập slug.',
            'slug.unique'                   => 'Slug đã tồn tại. Vui lòng chọn slug khác.',
            'slug.regex'                    => 'Trường này không được chứa dấu.',
            'status.required'               => 'Vui lòng chọn trạng thái.',
            'status.in'                     => 'Trạng thái không hợp lệ.',

        ];
    }
}
