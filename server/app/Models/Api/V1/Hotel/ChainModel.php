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
                // ->orderBy('type', 'asc')
                ->orderBy('priority', $params['direction'] ?? 'asc')
                ->limit($params['limit'] ?? 99)
                ->get() ?? [];
        }
        return $results;
    }
}
