<?php

namespace App\Http\Requests\Api\V1\Hms\HotelService;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_HOTEL_SERVICE;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validate = [
            'type'     => "required|in:hotel,room",
            'point_id' => "",
            'ids'      => "nullable|array"
        ];
        if (isset(request()->ids)) {
            $validate['ids.*'] = 'exists:' . TABLE_HOTEL_SERVICE . ',id';
        }
        if(!empty(request()->type) && request()->type == 'room'){
            $validate['point_id'] = 'required|exists:'.TABLE_HOTEL_ROOM.',id';
        }
        return $validate;
    }

    public function messages()
    {
      return [];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
}
