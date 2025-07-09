<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    private $table = TABLE_HOTEL_SERVICE;
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
        $id = $this->id;
        $condName               = "required|between:2,255";
        $condThumb              = "bail|nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2000";
        $condSlug               = "required|between:2,255|unique:{$this->table},slug" . ($id ? ",{$id}" : '');        
        $condStatus             = "bail|required|in:active,inactive";
        $condType               = "required|in:hotel,room";

        return [
            'name'              => $condName,
            'slug'              => $condSlug,
            'status'            => $condStatus,
            'type'              => $condType,
            'image'             => $condThumb

        ];
    }
    public function messages()
    {
        return [

            'name.required'                 => 'Vui lòng nhập dịch vụ & tiện ích.',
            'name.between'                  => 'Tên dịch vụ & tiện ích phải có độ dài từ 2 đến 255 ký tự.',

            'slug.required'                 => 'Vui lòng nhập slug.',
            'slug.between'                  => 'Slug phải có độ dài từ 2 đến 255 ký tự.',
            'slug.unique'                   => 'Slug đã tồn tại.',

            'status.required'               => 'Vui lòng chọn trạng thái.',
            'status.in'                     => 'Trạng thái không hợp lệ.',

            'type.required'                 => 'Vui lòng chọn loại.',
            'type.in'                       => 'Loại không hợp lệ.',

            'image.image'                   => 'Tập tin phải là hình ảnh.',
            'image.mimes'                   => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif, svg.',
            'image.max'                     => 'Hình ảnh không được lớn hơn 2MB.',

        ];
    }
    public function attributes()
    {
        return [

        ];
    }
}
