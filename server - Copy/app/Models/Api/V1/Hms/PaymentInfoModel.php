<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PaymentInfoModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PAYMENT_INFO;
        parent::__construct();
    }
    protected $guarded      = [];
    protected $hidden       = ['hotel_id','created_at','created_by','updated_at','updated_by','note'];

    public function listItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'list') {

            $hotel_id   = auth('hms')->user()->current_hotel_id;

            $query      = self::where(['hotel_id' => $hotel_id])->with('bank:id,name,code');

            if($params['search'] ?? false){
                
                $search = $params['search'];

                $query->where(function ($q) use ($search) {
                    $q->where('name_account', 'LIKE', '%' . $search . '%')
                    ->orWhere('number', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('bank', function ($bankQuery) use ($search) {
                        $bankQuery->where('name', 'LIKE', '%' . $search . '%')
                                ->orWhere('code', 'LIKE', '%' . $search . '%');
                    });
                });

            }

            if($params['status'] ?? false){
                $query->where('status',$params['status']);
            }

            $results    = $query->orderBy($params['column'] ?? 'created_at',$params['direction'] ?? 'desc')->paginate($params['limit'] ?? 20);
        }
        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        $results            = null;
        if ($options['task'] == 'add-item') {

            $params['hotel_id']         = auth('hms')->user()->current_hotel_id;
            $params['created_at']       = date('Y-m-d H:i:s');
            $params['created_by']       = auth('hms')->id();
            $params['is_default']       = false;
            $params['status']           = 'new';

            $results['id']              = self::insertGetId($this->prepareParams($params));

            
        }
        if ($options['task'] == 'update-item') {
            $results = [
                'status'    => true,
                'message'   => 'Thực hiện yêu cầu thành công!',
                'data'      => ['id' => $params['id']]
            ];

            $hotel_id                   = auth('hms')->user()->current_hotel_id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            $params['updated_by']       = auth('hms')->id();

            $item                       = self::where(['id' => $params['id']])->first();

            

            // cập nhật lại thông tin không đạt yêu cầu
            if($item->status != 'verified'){
                $params['status']           = 'new';
                $params['is_default']       = false;
                
                self::where('id',$params['id'])->update($this->prepareParams($params));
            }else{
                // chỉ cập nhật is_default
                if($params['is_default'] == true  ){

                    self::where([
                        'hotel_id'      => $hotel_id,
                        'status'        => 'verified'
                    ])
                    ->whereNot('id',$params['id'])
                    ->update(['is_default' => false]);
    
                    self::where(['id' => $params['id']])->update([
                        'updated_at'      => date('Y-m-d H:i:s'),
                        'updated_by'      => auth('hms')->id(),
                        'is_default'      => true
                    ]);
                }else{
                    $results    = [
                        ...$results,
                        'data'      => [
                                        'is_default' => ["Bạn không thể thay đổi tài khoản mặc định duy nhất"]
                                    ],
                        'status'    => false,
                        'message'   => 'Bạn không thể thay đổi tài khoản mặc định duy nhất'
                    ];
                }
            }
        }
        return $results;
    }
    public function getItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'detail') {

            $hotel_id   = auth('hms')->user()->current_hotel_id;

            $results    = self::where(['hotel_id' => $hotel_id, 'id' => $params['id']])
                        ->first();
        }
        return $results;
    }
    public function bank()  {
        return $this->belongsTo(BankModel::class,'bank_id','id');
    }
}
