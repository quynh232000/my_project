<?php

namespace App\Http\Requests\Api\V1\Hms\Customer;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
class UpdateRequest extends FormRequest
{
    use ApiResponse;
    private $table            = TABLE_HMS_CUSTOMER;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $validate =[
            'id'        => "sometimes|numeric|exists:{$this->table},id",
            'full_name' => 'required|string|max:255',
            'email'     => [
                            'required',
                            'email',
                            function ($attribute, $value, $fail)  {
                                $query = DB::table(TABLE_HOTEL_HOTEL_CUSTOMER.' as hhc')
                                    ->join(TABLE_HMS_CUSTOMER.' as c', 'c.id', '=', 'hhc.customer_id')
                                    ->where('c.email', $value)
                                    ->where('hhc.hotel_id', auth('hms')->user()->current_hotel_id);
                
                                if (request()->input('id') ?? false) {
                                    $query->where('c.id', '!=', request()->input('id'));
                                }
                
                                if ($query->exists()) {
                                    $fail('Email đã tồn tại trong khách sạn này.');
                                }
                            }
                        ],
            'password'  => 'required|string|min:6|confirmed',
            'role'      => 'required|in:manager,staff',
            'status'    => 'required|in:active,inactive',
        ];
        if(request()->id ?? false){
            $validate   = [
                ...$validate,
                'password'  => '',
            ];
        }
       
        return $validate;
    }

    public function messages()
    {
      return [];
    }
    protected function failedValidation($validator) 
    {
        throw new HttpResponseException($this->errorInvalidate('Dữ liệu không hợp lệ!', $validator->errors()));
    }
}
