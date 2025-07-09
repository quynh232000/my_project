<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class LocationModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_LOCATION;
        $this->hidden       = ['created_at','created_by','updated_at','updated_by'];
        $this->appends      = [];
    }
    public function listItem($params = null, $options = null){
        if($options['task'] == 'search'){
            $results = self::select('id', 'hotel_id', 'city_name', 'ward_name')
            ->where(function($q) use($params){
                $q->where('city_name', 'LIKE', '%'.$params['keyword'].'%')
                ->orWhere('ward_name', 'LIKE', '%'.$params['keyword'].'%');
            })
            ->get();
        }
        return $results;
    }
}
