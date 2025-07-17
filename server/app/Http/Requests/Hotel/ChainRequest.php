<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class ChainRequest extends FormRequest
{
    private $table = TABLE_HOTEL_POLICY_SETTING;
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
            'type'        => "bail|required",
        ];
    }
    public function messages()
    {
        return [
            'name.required'  => 'Vui lòng nhập đầy đủ thông tin.',
            'slug.required'  => 'Vui lòng nhập đầy đủ thông tin.',
            'slug.unique'    => 'Slug đã tồn tại, vui lòng nhập slug khác.',
            'status.slug'    => 'Vui lòng nhập đầy đủ thông tin.',
            'type.required'  => 'Vui lòng chọn loại.',
        ];
    }
}
