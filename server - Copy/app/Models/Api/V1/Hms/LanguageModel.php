<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class LanguageModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_GENERAL_COUNTRY;
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-items') {

            $limit      = $params['limit'] ?? 1000;

            $results    = self::select('id','name')
                        ->where('status','active')
                        ->limit($limit)
                        ->get();
        }
        return $results;
    }
}
