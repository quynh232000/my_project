<?php

namespace App\Models\Api\V1\Hotel;

use App\Models\ApiModel;

class ChainModel extends ApiModel
{
    private $bucket = 's3_hotel';
    public function __construct()
    {
        $this->table            = TABLE_HOTEL_CHAIN;
        $this->hidden           = [];
        $this->appends          = [];
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $results        = null;

        if ($options['task'] == 'list') {
            $results    = self::select('id', 'name', 'slug', 'logo', 'image', 'price')
                ->where(['status' => 'active'])
                ->orderBy('created_at', 'desc')
                ->orderBy('priority', $params['direction'] ?? 'asc')
                ->limit($params['limit'] ?? 8)
                ->get() ?? [];
        }
        return $results;
    }
    // public function getImageAttribute()
    // {
    //     return $this->attributes['image'] ? URL_DATA_IMAGE."hotel/chain/images/".$this->id.'/'. $this->attributes['image'] : null;
    // }
    // public function getLogoAttribute()
    // {
    //     return $this->attributes['logo'] ? URL_DATA_IMAGE."hotel/chain/images/".$this->id.'/'. $this->attributes['logo'] : null;
    // }
}
