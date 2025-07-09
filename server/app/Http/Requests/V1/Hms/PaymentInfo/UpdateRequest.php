<?php

namespace App\Http\Requests\Api\V1\Hms\PaymentInfo;

use App\Models\Api\V1\Hms\PaymentInfoModel;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HOTEL_PAYMENT_INFO;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
         $validate = [
           'id'     => [
                            "required",
                            Rule::exists($this->table, 'id')->where(function ($query) {
                                $query->where('hotel_id', auth('hms')->user()->current_hotel_id);
                            }),
                        ]
        ];

        $exists = PaymentInfoModel::where([
                    'hotel_id'  => auth('hms')->user()->current_hotel_id,
                    'status'    => 'verified',
                    'id'        => $this->route('payment_info')
                ])
                ->get();
        if($exists){
             $validate = [
                ...$validate,
                'is_default'        => ['required','boolean'] 
            ];
        }else{
            $validate = [
                ...$validate,
                'bank_id'           => 'required|exists:'.TABLE_HOTEL_BANK.',id',
                'name_account'      => ['required', 'string', 'max:255'],
                'number'            => ['required', 'string', 'max:50'],
                'type'              => ['required', 'in:personal,business'],

                'name_company'      => ['required_if:type,business', 'string', 'max:255'],
                'contact_person'    => ['required_if:type,business', 'string', 'max:255'],
                'address'           => ['required_if:type,business', 'string', 'max:500'],
                'tax_code'          => ['required_if:type,business', 'string', 'max:20'],
                'email'             => ['required_if:type,business', 'email', 'max:255'],
                'phone'             => ['required_if:type,business', 'string', 'max:20'],    
            ];
           
        }
        return $validate;
    }

    public function messages()
    {
        return [];
    }
    public function attributes()
    {
        return [];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('payment_info'),
        ]);
    }
}
