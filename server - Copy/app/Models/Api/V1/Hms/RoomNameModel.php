<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class RoomNameModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ROOM_NAME;
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

            $limit      = $params['limit'] ?? 9999;

            $query    = self::select('id','name','slug','room_type_id')
                        ->where('status','active');

            if(isset($params['room_type_id']) && !empty($params['room_type_id'])){
                $query->where('room_type_id',$params['room_type_id']);
            }

            $results = $query->limit($limit)
                        ->get();
        }
        return $results;
    }
}
