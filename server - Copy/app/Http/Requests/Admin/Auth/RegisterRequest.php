<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

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
            'email'         => 'required|email|exists:' . $this->table . ',email',
            'password'      => 'required|min:8',
            'full_name'     => 'required',
            'phone'         => 'required',
        ];
    }
}
