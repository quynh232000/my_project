<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    private $table = TABLE_HOTEL_LANGUAGE;
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->id;
        return [
            'name'        => "bail|required",
            'name_en'     => "bail|required",
            'code'        => "bail|required|unique:{$this->table},code" . ($id ? ",{$id}" : ''),
            'status'      => "bail|required|in:active,inactive",
        ];
    }
    public function messages()
    {
        return [
            'name.required'     => 'Vui lòng nhập đầy đủ thông tin.',
            'name_en.required'  => 'Vui lòng nhập đầy đủ thông tin.',
            'code.required'     => 'Vui lòng nhập đầy đủ thông tin.',
            'code.unique'       => 'Code đã tồn tại, vui lòng nhập code khác.',
            'status.required'   => 'Vui lòng nhập đầy đủ thông tin.',
        ];
    }
    public function attributes()
    {
        return [];
    }
}
