<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    private $table            = TABLE_HOTEL_POST;
     /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
        $condThumb              = "bail" . (!$id ? "|required" : "|nullable") . "|image|mimes:jpeg,png,jpg,gif,webp|max:2000";
        $condName               = "bail|required|between:2,255";
        $condSlug               = "bail|required|unique:{$this->table},slug" . ($id ? ",{$id}" : '');
        $condStatus             = "bail|required|in:active,inactive";
        $condContent            = "bail|nullable|min:10";
        $condDescription        = "bail|nullable|string|between:3,255";
        $condCategory           = "bail|required|exists:".TABLE_HOTEL_CATEGORY.",id";
        $condMetaTitle          = "bail|nullable|between:3,255";
        $condMetaDescription    = "bail|nullable|string|between:3,255";
        $condMetaKeyword        = "bail|nullable|string|between:3,255";
        return [
            'name'                  => $condName,
            'slug'                  => $condSlug,
            'status'                => $condStatus,
            'image'                 => $condThumb,
            'content'               => $condContent,
            'description'           => $condDescription,
            'category_id'           => $condCategory,
            'meta_title'            => $condMetaTitle,
            'meta_description'      => $condMetaDescription,
            'meta_keyword'          => $condMetaKeyword,
            // 'start_point'           => $condStartPoint,
            // 'end_point'             => $condEndPoint,
        ];
    }
    public function messages()
    {
        return [
            'name.required'             => 'Vui lòng nhập tiêu đề.',
            'name.between'              => 'Tiêu đề phải có độ dài từ 2 đến 255 ký tự.',
            'slug.required'             => 'Vui lòng nhập slug.',
            'slug.unique'               => 'Slug đã tồn tại. Vui lòng chọn slug khác.',
            'status.required'           => 'Vui lòng chọn trạng thái.',
            'status.in'                 => 'Trạng thái không hợp lệ.',
            'description.between'       => 'Mô tả phải có độ dài từ 3 đến 255 ký tự.',

            'content.required'          => 'Vui lòng nhập nội dung.',
            'content.min'               => 'Nội dung phải có độ dài từ 3 trở lên.',
            'category_id.required'      => 'Vui lòng chọn danh mục.',
            'category_id.exists'        => 'Danh mục không tồn tại.',
            // 'content.required'          => 'Vui lòng nhập nội dung.',
            'image.required'            => 'Vui lòng chọn hình ảnh.',
            'image.image'               => 'Tập tin phải là hình ảnh.',
            'image.mimes'               => 'Hình ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'image.max'                 => 'Hình ảnh không được lớn hơn 2MB.',

            'meta_title.between'        => 'Tiêu đề meta phải có độ dài từ 3 đến 255 ký tự.',
            'meta_description.between'  => 'Mô tả meta phải có độ dài từ 3 đến 255 ký tự.',
            'meta_keyword.between'      => 'Từ khóa meta phải có độ dài từ 3 đến 255 ký tự.',
        ];
    }

    public function attributes()
    {
        return [
            // 'description' => 'Field Description: ',
        ];
    }
}
