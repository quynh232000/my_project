<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class RoomTypeRequest extends FormRequest
{
    private $table = TABLE_HOTEL_ROOM_TYPE;
    public function authorize(): bool
    {
        return true;
    }

  
    public function rules(): array
    {
        $id         = $this->id;
        $validate   = [
            'name'       => 'required',
            'slug'       => 'required|unique:'.TABLE_HOTEL_ROOM_TYPE.',slug'. ($id ? ",{$id}" : ''),
           
        ];
        return $validate;
    }
    public function messages()
    {
        return [
          

        ];
    }
    public function attributes()
    {
        return [

        ];
    }
}
