<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class RoomExtraBedModel extends HmsModel
{


    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ROOM_EXTRA_BED;
        parent::__construct();
    }
    public function getItem($params = null, $options = null)
    {
        $results = null;
        
        if ($options['task'] == 'detail') {
            
        }
        if ($options['task'] == 'meta') {

            
        }

        return $results;
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'detail') {
            
        }
        
        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'add-item') {
            $params = array_map(function($item) use ( $options) {
                $item['room_id'] = $options['room_id'];
                return $item;
            }, $params);
            self::insert($this->prepareParams($params));
        }
        
        if ($options['task'] == 'edit-item') {
            foreach($params as $key => $item){
               self::where('id',$key)->update($this->prepareParams($item));
            }
        }

        return $results;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item'){
            self::whereIn('id',$params)->delete();
        }
    }
    public function getImageUrlAttribute()
    {
        return $this->attributes['image_url'] ?? null;
    }
    public function room(){
        return $this->belongsTo(RoomModel::class,'id', 'room_id');
    }

}
