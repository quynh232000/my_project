<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HotelRequest extends FormRequest
{
    private $table = TABLE_HOTEL_HOTEL;
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

        $validate = [
            'name'                  => "bail|required|between:2,255",
            // 'image'                 => "bail|".($id?'sometimes':'required')."|image|mimes:jpeg,png,jpg,gif,webp|max:2560",
            'slug'                  => "bail|required|unique:{$this->table},slug" . ($id ? ",{$id}" : ''),
            'status'                => "bail|required|in:active,inactive",
            // 'stars'                 => "bail|required|in:0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5",
            // 'description'           => "bail|required|string",
            // 'commission_rate'       => "bail|nullable|numeric|min:0",
            'address'               => "bail|required|string",
            // 'images'                => 'bail|sometimes|array',
            // 'images.*'              => 'bail|image|mimes:jpeg,png,jpg,gif,webp|max:2560',

            // 'abumn'                 => 'sometimes|array',
            // 'abumn.thumbnail'       => 'required|array',  // Ensure 'thumbnail' is an array
            // 'abumn.thumbnail.*'     => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            // 'abumn.*.name'          => 'sometimes|string|max:255',
            // 'abumn.*.images.*'      => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2560',
            // 'abumn.*.images'        => 'required_with:abumn.*.name|array',
            'accommodation_id'      => 'bail|required',
            'country_id'            => 'bail|required',
            'province_id'               => 'bail|required',
            // 'district_id'           => 'bail|required',
            'ward_id'               => 'bail|required',
            // 'latitude'              => 'required|numeric|between:-90,90',
            // 'longitude'             => 'required|numeric|between:-180,180',

            // 'location'              => 'nullable|array',
            // 'location.*.latitude'   => 'required_with:location.*.longitude|numeric',
            // 'location.*.longitude'  => 'required_with:location.*.latitude|numeric',
            // 'location.*.name'       => 'required',
            // 'location.*.address'    => 'required',
        ];


        if (!empty(request()->input('')))

            if ($id) {
                $validate = [
                    ...$validate,
                    'abumn'           => '',
                    'abumn.*.name'    => '',
                    'abumn.*.images.*' => '',
                    'abumn.*.images'  => '',
                ];
            }
        return $validate;
    }
    public function messages()
    {
        return [
            'name.required'                 => 'Vui lòng nhập tiêu đề.',
            'name.between'                  => 'Tiêu đề phải có độ dài từ 2 đến 255 ký tự.',
            'image.required'                => 'Vui lòng chọn ảnh.',
            'slug.required'                 => 'Vui lòng nhập slug.',
            'slug.unique'                   => 'Slug đã tồn tại. Vui lòng chọn slug khác.',
            'slug.regex'                    => 'Trường này không được chứa dấu.',
            'status.required'               => 'Vui lòng chọn trạng thái.',
            'status.in'                     => 'Trạng thái không hợp lệ.',
            'stars.in'                      => 'Hạng sao không hợp lệ.',
            'images.required'               => 'Vui lòng chọn hình ảnh.',
            'images.image'                  => 'Tập tin phải là hình ảnh.',
            'image.max'                     => 'File của bạn phải nhỏ hơn 2MB.',
            'commission_rate.numeric'       => 'Vui lòng nhập số.',
            'address.required'              => 'Vui lòng nhập địa chỉ.',
            'description.required'          => 'Vui lòng nhập đầy đủ thông tin.',
            'abumn.*.name.string'           => 'Vui lòng nhập đầy đủ thông tin.',
            'country_id'                    => 'Vui lòng chọn thông tin.',
            'city_id'                       => 'Vui lòng chọn thông tin.',
            'district_id'                   => 'Vui lòng chọn thông tin.',
            'ward_id'                       => 'Vui lòng chọn thông tin.',
            'latitude.required'             => 'Vui lòng chọn thông tin.',
            'longitude.required'            => 'Vui lòng nhập đầy đủ thông tin.',
            'latitude.numeric'              => 'Thông tin không đúng định dạng.',
            'longitude.numeric'             => 'Thông tin không đúng định dạng.',
            'latitude.between'              => 'Thông tin không đúng định dạng.',
            'longitude.between'             => 'Thông tin không đúng định dạng.',

            'abumn.*.images.*'              => 'Vui lòng nhập đầy đủ thông tin.',
            'abumn.*.images.*.mimes'        => ' chỉ được phép có định dạng jpeg, png, jpg, gif, hoặc webp.',
            'abumn.images.*.mimes'          => 'Chỉ được phép có định dạng jpeg, png, jpg, gif, hoặc webp.',
            'abumn.*.images.*.image'        => 'Chỉ được phép có định dạng jpeg, png, jpg, gif, hoặc webp.',
            'abumn.*.images.*.max'          => ' tối đa 2MB.',
            'accommodation_id.required'     => 'Vui lòng chọn thông tin.',

            'location.*.latitude'           => 'Vui lòng nhập thông tin.',
            'location.*.longitude'          => 'Vui lòng nhập thông tin.',
            'location.*.name'               => 'Vui lòng nhập đầy đủ thông tin.',
            'location.*.address'            => 'Vui lòng nhập đầy đủ thông tin.',
            'location.required'             => 'Vui lòng nhập thông tin vị trí.',
            'location.*.latitude.numeric'   => 'Thông tin không đúng định dạng.',
            'location.*.longitude.numeric'  => 'Thông tin không đúng định dạng.',
        ];
    }
    public function attributes()
    {
        return [];
    }
}
