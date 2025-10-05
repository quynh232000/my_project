<?php

namespace App\Http\Requests\Api\V1\Hms\Album;

use App\Models\Api\V1\Hms\AlbumModel;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_ALBUMN;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'slug'                  => 'sometimes|string|max:255',
            'type'                  => 'required|in:room_type,hotel',
            'delete_images'         => 'sometimes|array',
            'delete_images.*'       => 'integer|exists:'.$this->table.',id',

            'update'             => 'sometimes|array',
            'update.*.image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'update.*.label_id'  => 'nullable|integer|exists:'.TABLE_HOTEL_ATTRIBUTE.',id',
        ];

        if (request('type') === 'room_type') {
            $rules['id'] = [
                            'required',
                            'integer',
                            Rule::exists(TABLE_HOTEL_ROOM, 'id')
                                ->where('hotel_id', auth('hms')->user()->current_hotel_id),
                        ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [
          
        ];
    }
    public function withValidator($validator)
    {
        // update[737][image] => check 737 is valid
        $validator->after(function ($validator) {
            $update = $this->input('update', []);
            foreach ($update as $imageId => $data) {
                if (!is_numeric($imageId)) {
                    $validator->errors()->add("update", "Mỗi phần tử update phải có ID hợp lệ.");
                    continue;
                }
                $exists = AlbumModel::where('id', $imageId)
                                    ->where('hotel_id', auth('hms')->user()->current_hotel_id)
                                    ->exists();
                if (!$exists) {
                    $validator->errors()->add("update.$imageId", "Ảnh với ID $imageId không tồn tại.");
                    continue;
                }
            }
        });
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ! ', $validator->errors()));
    }

}
