<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    protected $table;
    public function __construct()
    {
        parent::__construct();
        $this->table = config('constants.table.general.TABLE_ORGANIZATION');
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
            'name' => 'required|string|min:5'
        ];
    }
}
