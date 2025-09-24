<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttributeRequest extends FormRequest
{
    private $table = TABLE_HOTEL_ATTRIBUTE;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->id;
        $condName               = "bail|required|between:2,255";
        $condSlug               = "bail|required|regex:/^[\x{0000}-\x{007F}]*$/u|unique:{$this->table},slug" . ($id ? ",{$id}" : '');
        $condStatus             = "bail|required|in:active,inactive";

        $condSlug =   [
            'required',
            Rule::unique($this->table)->where(function ($query) {
                return $query->where('slug', $this->slug)
                             ->where('parent_id', $this->parent_id);
            })->ignore($id),
        ];

        return [
            'name'                  => $condName,
            'slug'                  => $condSlug,
            'status'                => $condStatus,
          
        ];
    }

    public function messages()
    {
        return [
            'name.required'                 => 'Vui lòng nhập tên.',
            'name.between'                  => 'Tên phải có độ dài từ 2 đến 255 ký tự.',
            'slug.required'                 => 'Vui lòng nhập slug.',
            'slug.unique'                   => 'Slug đã tồn tại. Vui lòng chọn slug khác.',
            'slug.regex'                    => 'Trường này không được chứa dấu.',
            'status.required'               => 'Vui lòng chọn trạng thái.',
            'status.in'                     => 'Trạng thái không hợp lệ.',
            
        ];
    }
}
