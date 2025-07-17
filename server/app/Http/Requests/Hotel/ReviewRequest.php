<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        $condHotel              = "required|exists:" . TABLE_HOTEL_HOTEL . ",id";
        $condName               = "required|between:2,255";
        $condThumb              = "bail|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2000";
        $condPoint              = "required|numeric|min:1|max:10";
        $condReview             = "bail|nullable|string|min:10";
        $condLike               = "bail|nullable|numeric|min:0";
        $condStatus             = "required|in:active,inactive";
        $condQualityPoint       = "numeric|min:1|max:5";
        // $condTime               = "date_format:Y-m-d";
        $qualities              = request()->input('qualities', []);
        $condQuality            = [];
        foreach ($qualities as $qualityItem) {
            if ($qualityItem['quality_point'] != 1 && is_null($qualityItem['quality'])) {
                $condQuality = "required";
            }
        }
        return [
            'hotel_id'          => $condHotel,
            'username'          => $condName,
            'images.user'       => $condThumb,
            'images.review.*'   => $condThumb,
            'point'             => $condPoint,
            'review'            => $condReview,
            'like'              => $condLike,
            'status'            => $condStatus,
            'qualities.*.quality_point' => $condQualityPoint,
            'qualities.*.quality' => $condQuality,
            
        ];
    }
    public function messages()
    {
        return [
            'hotel_id.required'                     => 'Vui lòng chọn khách sạn.',
            'hotel_id.exists'                       => 'Khách sạn không tồn tại.',

            'username.required'                     => 'Vui lòng nhập tên người đánh giá.',
            'username.between'                      => 'Tên dịch vụ phải có độ dài từ 2 đến 255 ký tự.',

            // 'images.user.*.required'                      => 'Vui lòng chọn hình ảnh.',
            'images.review.*.image'                 => 'Tập tin phải là hình ảnh.',
            'images.review.*.mimes'                 => 'Hình ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'images.review.*.max'                   => 'Hình ảnh không được lớn hơn 2MB.',

            'images.user.image'                     => 'Tập tin phải là hình ảnh.',
            'images.user.mimes'                     => 'Hình ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'images.user.max'                       => 'Hình ảnh không được lớn hơn 2MB.',

            'point.required'                        => 'Vui lòng nhập điểm đánh giá.',
            'point.numeric'                         => 'Điểm đánh giá phải là số.',
            'point.min'                             => 'Điểm đánh giá từ 1 đến 10.',
            'point.max'                             => 'Điểm đánh giá từ 1 đến 10.',

            'like.numeric'                          => 'Vui lòng nhập số.',
            'like.min'                              => 'Số không được âm.',

            'status.required'                       => 'Vui lòng chọn trạng thái.',
            'status.in'                             => 'Trạng thái không hợp lệ.',

            'review.min'                            => 'Đánh giá phải có độ dài từ 3 ký tự.',

            'qualities.*.quality_point.required'    => 'Vui lòng nhập điểm đánh giá',
            'qualities.*.quality_point.min'         => 'Điểm đánh giá từ 1 đến 5.',
            'qualities.*.quality_point.max'         => 'Điểm đánh giá từ 1 đến 5.',

            'qualities.*.quality.required'          => 'Vui lòng chọn tiêu chí đánh giá',
        ];
    }
    public function attributes()
    {
        return [

        ];
    }
}
