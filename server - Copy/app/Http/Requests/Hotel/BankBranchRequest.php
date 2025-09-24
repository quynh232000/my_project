<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class BankBranchRequest extends FormRequest
{
    private $table = TABLE_HOTEL_BANK_BRANCH;
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->id;
        return [
            'bank_id'       => "bail|required",
            'name'          => "bail|required",
            'address'       => "bail|required",
            'phone'         => "bail|required",
            'status'        => "bail|required|in:active,inactive",
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
