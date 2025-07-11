<?php

namespace App\Http\Requests\Admin\Ecommerce;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    protected $table;
    public function __construct()
    {
        parent::__construct();
        $this->table = config('constants.table.ecommerce.TABLE_Shop');
    }
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
        return [
            'name'              => 'required|string|min:5',
            'email'             => 'required|string|email',
            'bio'               => 'required|string|min:5',
            'address_detail'    => 'required|string|min:5',
            'phone_number'      => 'required|string|min:5',
        ];
    }
}
