<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = config('constants.table.general.TABLE_USER');
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
            'email'         => 'required|email|unique:' . $this->table . ',email,'.$this->id,
            'full_name'     => 'required',
            'phone'         => 'required',
        ];
    }
}
