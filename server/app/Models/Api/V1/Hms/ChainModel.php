<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class ChainModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_CHAIN;
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

            $limit      = $params['limit'] ?? 1000;

            $query      = self::select('id','name','type')
                        ->where('status','active');
            if($params['type'] ?? false){
                $query->where('type',$params['type']);
            }
            $results = $query->limit($limit)
                        ->orderBy('id', $params['direction'] ?? 'asc')
                        ->get();
        }
        return $results;
    }
}
