<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class RoomTypeModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ROOM_TYPE;
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

            $limit      = $params['limit'] ?? 9999;

            $query    = self::select('id','name','slug')
                        ->where('status','active');
            if(isset($params['with_name']) && $params['with_name']){
                $query->with(['room_names:id,name,room_type_id']);
            }
            $results = $query            ->limit($limit)
                        ->get();
        }
        return $results;
    }
    public function room_names() {
        return $this->hasMany(RoomNameModel::class,'room_type_id','id');
    }
}
