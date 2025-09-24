<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
class RoomModel extends HmsModel
{

    public $crudNotAccepted = ['fe_extra_beds','update_fe_extra_beds','delete_fe_extra_beds','images','image_delete','name_custom'];
    protected $guarded = [];
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ROOM;
        parent::__construct();
    }
    protected $hidden       = ['pivot','updated_by','created_by','updated_at'];

    public function getItem($params = null, $options = null)
    {
        $results = null;
        
        if ($options['task'] == 'detail') {
            $item = self::select(
                'id',
                'name_id',
                'name',
                'status',
                'type_id',
                'direction_id',
                'area',
                'quantity',
                'smoking',
                'breakfast',
                'price_min',
                'price_standard',
                'price_max',
                'bed_type_id',
                'bed_quantity',
                'sub_bed_type_id',
                'sub_bed_quantity',
                'allow_extra_guests',
                'standard_guests',
                'max_extra_adults',
                'max_extra_children',
                'max_capacity'
            )
            ->with('extraBeds')
            ->where(['id' => $params['id'], 'hotel_id' => auth('hms')->user()->current_hotel_id])
            ->first();
            return $item;
        }
        
        if ($options['task'] == 'meta') {

            
        }

        return $results;
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'list-item') {
            $hotelId        = auth('hms')->user()->current_hotel_id;

            $query          = self::select('id','name_id','name','max_extra_adults','max_extra_children','max_capacity','area','quantity','status','price_min','price_standard','price_max')
                            ->with('price_types:id,name')
                            ->where('hotel_id', $hotelId);

            if($params['search'] ?? false){
                $query->where(function($q) use ($params) {
                    $q->where('name', 'LIKE', "%".$params['search']."%")
                    ->orWhere('id', $params['search'])
                    ;
                });
            }

            if($params['status'] ?? false){
                $query->where('status', $params['status']== 'active' ? 'active' : 'inactive');
            }
                            
            $item           = $query->orderBy($params['column'] ?? 'created_at',$params['direction'] ?? 'desc')
                            ->paginate($params['limit'] ?? 20);
            return $item;
           
        }
        
        if($options['task'] == 'list-all'){
            return self::select('id','name_id','name')
                    ->with('price_types:id,name')
                    ->where(['hotel_id'=>auth('hms')->user()->current_hotel_id])
                    ->orderBy('created_at','desc')
                    ->get();
        }
        if ($options['task'] == 'list') {

            $from = Carbon::parse($params['start_date'] ?? Carbon::now());
            $to   = Carbon::parse($params['end_date'] ?? Carbon::now()->addYear());

            // Lấy tất cả phòng trong khoảng thời gian
            $rooms      = self::select([
                            'id', 'name_id', 'name', 'price_min', 'quantity', 'price_standard', 'price_max',
                            'allow_extra_guests', 'standard_guests', 'max_extra_adults',
                            'max_extra_children', 'max_capacity', 'type_id'
                        ])
                        ->with(['price_settings',
                            'price_details'=>fn($q) => $q->select('id','date','room_booked','room_id')->whereBetween('date',[$from,$to])    
                        ])
                        ->where(['hotel_id' => auth('hms')->user()->current_hotel_id, 'status' => 'active'])
                        ->orderBy('created_at', $params['orderby_asc'] ?? 'desc')
                        ->limit($params['limit'] ?? 20)->get();


            // Lấy tất cả rooms ids
            $roomIds    = $rooms->pluck('id');

            // Lấy các dữ liệu liên quan cho tất cả phòng trong khoảng thời gian và nhóm theo room_id
            $quantities = RoomQuantityModel::whereIn('room_id', $roomIds)
                        ->where('start_date', '<=', $to)
                        ->where('end_date', '>=', $from)
                        ->get()
                        ->groupBy('room_id');

            $statuses   = RoomStatusModel::whereIn('room_id', $roomIds)
                        ->where('start_date', '<=', $to)
                        ->where('end_date', '>=', $from)
                        ->get()
                        ->groupBy('room_id');

            $prices     = RoomPriceModel::with('priceType:id,name,rate_type')
                        ->whereIn('room_id', $roomIds)
                        ->where('is_active', true)
                        ->where('start_date', '<=', $to)
                        ->where('end_date', '>=', $from)
                        ->get()
                        ->groupBy('room_id');
            // Gán lại dữ liệu theo từng phòng
            $results    = $rooms->map(function ($room) use ($params, $quantities, $statuses, $prices) {
                $room_id                = $room->id;

                // Lấy lịch trình cho từng phòng
                $room->availability     = $this->buildSchedule(
                                            [...$params,'price_details' => $room->price_details],
                                            $quantities[$room_id] ?? collect(),
                                            $statuses[$room_id] ?? collect(),
                                            $prices[$room_id] ?? collect()
                                        );
                
                // Lấy các loại giá đã áp dụng cho từng phòng
                $room->room_price_types = $this->buildPriceTypes(
                                            $prices[$room_id] ?? collect()
                                        );
                unset($room->price_details);                           
                return $room;
            });
        }
        
        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'add-item') {
            $params['created_by']   = auth('hms')->id();
            $params['created_at']   = date('Y-m-d H:i:s');
            $params['hotel_id']     = auth('hms')->user()->current_hotel_id;

            // Check has name_custom, if not, use name from name_id
            if(isset($params['name_custom']) && !empty($params['name_custom'])){
                $params['name'] = $params['name_custom'];
            }else{
                $params['name'] = optional(RoomNameModel::find($params['name_id']))->name ?? '';
            }

            $item = self::create($this->prepareParams($params));
            if(isset($params['fe_extra_beds'])){
                $extraBedModel = new RoomExtraBedModel();
                $extraBedModel->saveItem($params['fe_extra_beds'], ['task' => 'add-item', 'room_id' => $item->id]);
            }
            if($item){
                return [
                    'status'        => true,
                    'status_code'   => 200,
                    'message'       => 'Cập nhật thành công!',
                    'data'          => [
                        'id' => $item->id
                    ]
                ];
            }else{
                return [
                    'status'        => false,
                    'status_code'   => 200,
                    'message'       => 'Cập nhật thất bại!'
                ];
            }
        }
        if ($options['task'] == 'edit-item') {
            $params['updated_by']   = auth('hms')->id();
            $params['updated_at']   = date('Y-m-d H:i:s');
            $extraBedModel = new RoomExtraBedModel();
            
            if(isset($params['fe_extra_beds'])){
                $extraBedModel->saveItem($params['fe_extra_beds'], ['task' => 'add-item', 'room_id' => $params['id']]);
            }
            if(isset($params['update_fe_extra_beds'])){
                $extraBedModel->saveItem($params['update_fe_extra_beds'], ['task' => 'edit-item']);
            }
            if(isset($params['delete_fe_extra_beds'])){
                $extraBedModel->deleteItem($params['delete_fe_extra_beds'], ['task' => 'delete-item']);
            }

            $item = self::findOrFail( $params['id']);

            // Check has name_custom, if not, use name from name_id
            if(isset($params['name_custom']) && !empty($params['name_custom'])){
                $params['name'] = $params['name_custom'];
            }else{
                $params['name'] = optional(RoomNameModel::find($params['name_id']))->name ?? '';
            }

            $item->update($this->prepareParams($params));
            
            if($item){
                return [
                    'status'        => true,
                    'status_code'   => 200,
                    'message'       => 'Cập nhật thành công!',
                    'data'          => [
                        'id' => $params['id']
                    ]
                ];
            }else{
                return [
                    'status'        => false,
                    'status_code'   => 200,
                    'message'       => 'Cập nhật thất bại!'
                ];
            }
        }

        if ($options['task'] == 'toggle-status') {
            
            $params['updated_by']   = auth('hms')->id();
            $params['updated_at']   = date('Y-m-d H:i:s');
            $hotel_id               = auth('hms')->user()->current_hotel_id;

            self::whereIn('id', $params['room_ids'])
                    ->where('hotel_id',$hotel_id)
                    ->update([
                        'status'        => $params['status'],
                        'updated_by'    => auth('hms')->id(),
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);

            return [
                'status'        => true,
                'status_code'   => 200,
                'message'       => 'Cập nhật thành công!',
                'data'          => [
                    'id' => $params['room_ids']
                ]
            ];
        }
        return $results;
    }


    public function buildSchedule($params, $quantities, $statuses, $prices)
    {
        $from       = Carbon::parse($params['start_date'] ?? Carbon::now());
        $to         = Carbon::parse($params['end_date'] ?? Carbon::now()->addYear());

        $results    = [];

        // Sử dụng copy để tránh thay đổi giá trị gốc của $from
        $date       = $from->copy();
        
        // Duyệt từng ngày trong khoảng từ $from đến $to
        while ($date->lte($to)) {
            $dow            = $date->dayOfWeekIso;

            // Lấy quantity, status và prices theo ngày
            // Tìm quantity theo ngày
            $quantity       = $quantities->first(fn($q) => $q->day_of_week == $dow && Carbon::parse($q->start_date)->lte($date) && Carbon::parse($q->end_date)->gte($date));
            // Tìm status theo ngày
            $status         = $statuses->first(fn($s) => $s->day_of_week == $dow && Carbon::parse($s->start_date)->lte($date) && Carbon::parse($s->end_date)->gte($date));

            // Tìm prices theo ngày
            $pricesInDay    = $prices->filter(fn($p) => $p->day_of_week == $dow && Carbon::parse($p->start_date)->lte($date) && Carbon::parse($p->end_date)->gte($date))
                ->map(fn($p) => [
                    'price_type_id'   => $p->price_type_id,
                    'price_type_name' => $p->price_type_id == 0 ? 'Giá tiêu chuẩn' : optional($p->priceType)->name,
                    'price'           => $p->price,
                ])->values();

            // Thêm vào kết quả
             $roomBooked = $params['price_details']->first(fn($item) => $item->date == $date->toDateString())->room_booked ?? 0;

            $results[] = [
                'date'          => $date->toDateString(),
                'quantity'      => $quantity->quantity ?? null,
                'room_booked'   => $roomBooked,
                'status'        => $status->status ?? null,
                'prices'        => $pricesInDay,
            ];

            // Tăng ngày lên
            $date->addDay();
        }

        return $results;
    }

    public function buildPriceTypes($prices)
    {
        // Lấy tất cả price_type_id duy nhất
        return $prices
            ->unique('price_type_id')
            ->map(fn($item) => [
                'price_type_id'     => $item->price_type_id,
                'price_type_name'   => $item->price_type_id == 0 ? 'Giá tiêu chuẩn' : optional($item->priceType)->name,
            ])
            ->values();
    }


    public function getImageUrlAttribute()
    {
        return $this->attributes['image_url'] ?? null;
    }
    public function extraBeds(){
        return $this->hasMany(RoomExtraBedModel::class,'room_id','id');
    }
    public function roomType() {
        return $this->belongsTo(AttributeModel::class,'type_id','id');
    }
    public function room_quantities()  {
        return $this->hasMany(RoomQuantityModel::class,'room_id','id');
    }
    public function room_statuses()  {
        return $this->hasMany(RoomStatusModel::class,'room_id','id');
    }
    public function room_prices()  {
        return $this->hasMany(RoomPriceModel::class,'room_id','id');
    }
    public function price_settings() {
        return $this->hasMany(PriceSettingModel::class,'room_id','id');
    }
    public function price_types() {
        return $this->belongsToMany(PriceTypeModel::class, TABLE_HOTEL_PRICE_TYPE_ROOM, 'room_id', 'price_type_id');
    }
    public function amenities(){
        return $this->belongsToMany(ServiceModel::class,TABLE_HOTEL_HOTEL_SERVICE,'point_id','service_id')->select('id','name')->where(TABLE_HOTEL_HOTEL_SERVICE.'.type','room');
    }
    public function price_details(){
        return $this->hasMany(PriceDetailModel::class,'room_id','id');
    }
    
}
