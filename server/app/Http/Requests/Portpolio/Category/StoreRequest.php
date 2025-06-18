<?php

namespace App\Http\Requests\Portfolio\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    protected $table;
    public function __construct()
    {
        parent::__construct();
        $this->table = config('constants.table.portfolio.TABLE_CATEGORY');
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
            'name'  => 'required|string|min:5',
            'email' => 'required|email',
        ];
    }
}
