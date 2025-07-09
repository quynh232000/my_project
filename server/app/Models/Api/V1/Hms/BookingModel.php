<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class BookingModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_BOOKING_ORDER;
        parent::__construct();
    }
    protected $casts        = [
                                'price_type' => 'array'
                            ]; 
    protected $hidden       = [
                                'created_by','updated_at','updated_by'
                            ];
    protected $guarded      = [];

    public $crudNotAccepted = [];

    public function getItem($params = null, $options = null)
    {
        if ($options['task'] == 'item-info') {

            $withRelation   = [
                                'deputy',
                                'daily_prices',
                                'room:id,name',
                                'room.amenities:id,name',
                                'hotel:id,name',
                                'hotel.policy_others',
                                'hotel.policy_others.policy_name:id,name',
                                'hotel.policy_generals.policy_name:id,name',
                                'hotel.policy_cancellations'=> fn($q) => $q->where('is_global',true),
                                'hotel.policy_cancellations.policy_cancel_rules',
                            ];

            $order          = self::with($withRelation)->find($params['id']);

            return $order;
        }
       
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'index') {
            $hotel_id       = auth('hms')->user()->current_hotel_id;

            $withRelation = [
                                'deputy:id,order_id,full_name',
                                'room:id,name'
                            ];

            $query          = self::select([
                                    $this->table.'.id',
                                    $this->table.'.code',
                                    $this->table.'.created_at',
                                    $this->table.'.depart_date',
                                    $this->table.'.return_date',
                                    $this->table.'.duration',
                                    $this->table.'.quantity',
                                    $this->table.'.final_money',
                                    $this->table.'.status',
                                    $this->table.'.price_type_id',
                                    $this->table.'.adt',
                                    $this->table.'.chd',
                                    $this->table.'.room_id'
                                ])
                                ->with($withRelation)
                                ->where('hotel_id',$hotel_id);
            
            if($params['code'] ?? false){
                $query->where('code','LIKE','%'.$params['code'].'%');
            }
            if(($params['date_from'] ?? false) && ($params['date_to'] ?? false)){

                $from   = Carbon::parse($params['date_from']);
                $to     = Carbon::parse($params['date_to']);
                $query->whereBetween('created_at', [$from, $to]);
            }
            if($params['created_at'] ?? false){
                $created_at   = Carbon::parse($params['created_at']);
                $query->whereDate('created_at', $created_at);
            }
            if(isset($params['price_type_id'])){
                $query->where('price_type_id', $params['price_type_id']);
            }
            if(isset($params['room_id'])){
                $query->where('room_id', $params['room_id']);
            }
            if($params['status'] ?? false){
                $query->where('status', $params['status']);
            }

            $query->orderBy('created_at','desc');
            $results        = $query->paginate($params['limit'] ?? 10);

            return $results;
        }
    }
    public function deputy(){
        return $this->hasOne(BookingDeputyModel::class,'order_id','id');
    }
    public function room(){
        return $this->belongsTo(RoomModel::class,'room_id','id');
    }
    public function hotel(){
        return $this->belongsTo(HotelModel::class,'hotel_id','id');
    }
    public function daily_prices(){
        return $this->hasOne(BookingDailyPriceModel::class,'order_id','id');
    }

    public function getPaymentStatusAttribute($value)
    {
         $data  = [
                    0 => 'Chưa thanh toán',
                    1 => 'Đã thanh toán',
                ];
        return $data[$value] ?? $value;
    }
    public function getStatusAttribute($value)
    {
        $data   = [
                    0 => 'Chờ xác nhận',
                    1 => 'Đã xử lý',
                    2 => 'Đã hủy bỏ',
                ];
        return $data[$value] ?? $value;
    }
   
}
