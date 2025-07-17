<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PromotionModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PROMOTION;
        parent::__construct();
    }
    protected $guarded      = [];
    protected $hidden       = ['created_at', 'created_by', 'updated_at','pivot'];
    public $crudNotAccepted = [
                                'price_type_ids',
                                'room_ids'
                            ];
    protected $casts        = [
                                'value' => 'array',
                            ];
    public function listItem($params = null, $options = null)
    {
        $results                        = null;
        if ($options['task'] == 'list-item') {

            $hotel_id                           = auth('hms')->user()->current_hotel_id;
            $results['data']['roomCount']       = RoomModel::where('hotel_id',$hotel_id)->count();
            $results['data']['priceTypeCount']  = PriceTypeModel::where('hotel_id',$hotel_id)->count();

            $query                      = self::where('hotel_id',$hotel_id)
                                        ->with(['price_types:id,name','rooms:id,name_id,name']);

            // Filter
            if($params['status'] ?? false){
                $query->where('status', $params['status']== 'active' ? 'active' : 'inactive');
            }
            if($params['search'] ?? false){
                $query->where('name', "LIKE","%".$params['search']."%");
            }

            $results['items']           = $query->orderBy($params['column'] ?? 'created_at',$params['direction'] ?? 'desc')
                                          ->paginate($params['limit'] ?? 20);
            $results['data']['items']   = $results['items']->items();
        }
        return $results;
    }
    public function saveItem($params = null, $options = null){
        $result                         = null;

        if ($options['task'] == 'add-item') {

            $params['hotel_id']         = auth('hms')->user()->current_hotel_id;
            $params['created_at']       = date('Y-m-d H:i:s');
            $params['created_by']       = auth('hms')->id();
            $params['status']           = $params['status'] ?? 'active';

            if(($params['type'] ?? null) == 'day_of_weeks'){
                foreach ($params['value'] as $key => $value) {
                   $params['day_'.$value['day_of_week']] = $value['value'];
                }
                $params['value']        = null;
            }


            $item                       = self::create($this->prepareParams($params));
            $options['insert_id']       = $item->id;
            
            if(count($params['price_type_ids'] ?? []) > 0){
                $PromotionPriceType     = new PromotionPriceTypeModel();
                $PromotionPriceType->saveItem($params['price_type_ids'],$options);
            }

            if(count($params['room_ids'] ?? []) > 0){
                $PromotionRoomModel     = new PromotionRoomModel();
                $PromotionRoomModel->saveItem($params['room_ids'],$options);
            }
            $result                     = $options['insert_id'];
        }
        if ($options['task'] == 'edit-item') {
            $params['hotel_id']         = auth('hms')->user()->current_hotel_id;
            $params['updated_at']       = date('Y-m-d H:i:s');
            $params['updated_by']       = auth('hms')->id();

            $options['insert_id']       = $params['id'];

            for ($i=1; $i <=7; $i++) { 
                    $params['day_'.$i] = 0;
            }
            if(($params['type'] ?? null) == 'day_of_weeks'){
                foreach ($params['value'] as $key => $value) {
                   $params['day_'.$value['day_of_week']] = $value['value'];
                }
                $params['value']        = null;
            }
            
            if(count($params['price_type_ids'] ?? []) > 0){
                $PromotionPriceType     = new PromotionPriceTypeModel();
                $PromotionPriceType->saveItem($params['price_type_ids'],$options);
            }
            
            if(count($params['room_ids'] ?? []) > 0){
                $PromotionRoomModel     = new PromotionRoomModel();
                $PromotionRoomModel->saveItem($params['room_ids'],$options);
            }

            $params['end_date']         = $params['end_date'] ?? null;
            
            $item = self::where('id',$params['id'])->firstOrFail();
            $item->update($this->prepareParams($params));
            
            $result                     = $params['id'];

        }
        if($options['task'] == 'toggle-status'){
            
            $item                       = self::find($params['id']);
            $item->status               = $item->status == 'active' ? 'inactive' : 'active';
            $item->updated_at           = date('Y-m-d H:i:s');
            $item->updated_by           = auth('hms')->id();
            $item->save();
            $result                     = $params['id'];
        }
        return ['id' => $result];
    }
    public function getItem($params = null, $options = null){

        $result     = null;

        if ($options['task'] == 'item-info') {
            
            $result = self::with(['price_types:id,name','rooms:id,name_id,name'])
                        ->where(['id' => $params['id'], 'hotel_id' => auth('hms')->user()->current_hotel_id])->first();
            if($result->type == 'day_of_weeks'){
                $value          = [];
                for ($i=1; $i <= 7; $i++) { 
                    $value[]    = [
                                    'day_of_week' => $i,
                                    'value'       => $result->{'day_'.$i}
                                ];
                }
                $result->value = $value;
            }
        }

        return $result;
    }
    public function price_types() {
        return $this->belongsToMany(PriceTypeModel::class,TABLE_HOTEL_PROMOTION_PRICE_TYPE,'promotion_id','price_type_id');
    }
    public function rooms() {
        return $this->belongsToMany(RoomModel::class,TABLE_HOTEL_PROMOTION_ROOM,'promotion_id','room_id');
    }
   
}
