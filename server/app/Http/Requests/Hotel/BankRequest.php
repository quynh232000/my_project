<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
    private $table = TABLE_HOTEL_BANK;
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->id;
        return [
            'name'        => "bail|required",
            'short_name'  => "bail|required",
            'code'        => "bail|required|unique:{$this->table},code" . ($id ? ",{$id}" : ''),
            'status'      => "bail|required|in:active,inactive",
        ];
    }
    public function messages()
    {
        return [
            'name.required'     => 'Vui lòng nhập đầy đủ thông tin.',
            'short_name.required'  => 'Vui lòng nhập đầy đủ thông tin.',
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
