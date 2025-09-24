<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class HotelCategoryRequest extends FormRequest
{
    private $table = TABLE_HOTEL_HOTEL_CATEGORY;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->id;
        $condThumb              = "bail|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2000";
        $condName               = "bail|required|between:2,255";
        $condSlug               = "bail|required|regex:/^[\x{0000}-\x{007F}]*$/u|unique:{$this->table},slug" . ($id ? ",{$id}" : '');
        $condStatus             = "bail|required|in:active,inactive";
        $condDescription        = "bail|nullable|string";

        $condMetaTitle          = "bail|nullable";
        $condMetaDescription    = "bail|nullable|string";
        $condMetaKeyword        = "bail|nullable|string";

        // if($id > 0){
        //     $condName .= "," . $id;
        // }

        return [
            'name'                  => $condName,
            'slug'                  => $condSlug,
            'status'                => $condStatus,
            // 'image'                 => $condThumb,
            // 'description'           => $condDescription,
            // 'meta_title'            => $condMetaTitle,
            // 'meta_description'      => $condMetaDescription,
            // 'meta_keyword'          => $condMetaKeyword,
        ];
    }

    public function messages()
    {
        return [
            'name.required'                 => 'Vui lòng nhập tiêu đề.',
            'name.between'                  => 'Tiêu đề phải có độ dài từ 2 đến 255 ký tự.',
            'slug.required'                 => 'Vui lòng nhập slug.',
            'slug.unique'                   => 'Slug đã tồn tại. Vui lòng chọn slug khác.',
            'slug.regex'                    => 'Trường này không được chứa dấu.',
            'status.required'               => 'Vui lòng chọn trạng thái.',
            'status.in'                     => 'Trạng thái không hợp lệ.',
            'description.between'           => 'Mô tả phải có độ dài từ 3 đến 255 ký tự.',

            'image.required'                => 'Vui lòng chọn hình ảnh.',
            'image.image'                   => 'Tập tin phải là hình ảnh.',
            'image.mimes'                   => 'Hình ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'image.max'                     => 'Hình ảnh không được lớn hơn 5MB.',

            'meta_title.between'            => 'Tiêu đề meta phải có độ dài từ 3 đến 255 ký tự.',
            'meta_description.between'      => 'Mô tả meta phải có độ dài từ 3 đến 255 ký tự.',
            'meta_keyword.between'          => 'Từ khóa meta phải có độ dài từ 3 đến 255 ký tự.',
        ];
    }
    public function attributes()
    {
        return [
            // 'description' => 'Field Description: ',
        ];
    }
}
