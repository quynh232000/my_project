<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    private $table = TABLE_HMS_CUSTOMER;
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id                 = $this->id;

        return [
            // 'register_id'   => "bail|string".($id ? '' : '|required'),
            'email'         => "bail|required|string|email". ($id ? '' : "|unique:{$this->table},email"),
            'full_name'     => "bail|required|string",
            'username'      => "bail|required|string".($id ? '' : "|unique:{$this->table},username"),
            'phone'         => "bail|required|string",
            // 'title'         => "bail|required|string",
            'password'      => "bail".($id ? '' : '|required'),
        ];
    }
    public function messages()
    {
        return [

        ];
    }
    public function attributes()
    {
        return [];
    }
}
