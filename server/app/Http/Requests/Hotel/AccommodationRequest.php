<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class AccommodationRequest extends FormRequest
{
    private $table = TABLE_HOTEL_ACCOMMODATION;
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->id;
        return [
            'name'        => "bail|required",
            'slug'        => "bail|required|unique:{$this->table},slug" . ($id ? ",{$id}" : ''),
            'status'      => "bail|required|in:active,inactive",
        ];
    }
    public function messages()
    {
        return [
            'name.required'  => 'Vui lòng nhập đầy đủ thông tin.',
            'slug.required'  => 'Vui lòng nhập đầy đủ thông tin.',
            'slug.unique'    => 'Slug đã tồn tại, vui lòng nhập slug khác.',
            'status.slug'    => 'Vui lòng nhập đầy đủ thông tin.',
        ];
    }
    public function attributes()
    {
        return [];
    }
}
