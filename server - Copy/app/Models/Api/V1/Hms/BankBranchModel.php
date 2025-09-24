<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class BankBranchModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_BANK_BRANCH;
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {
            $limit      = $params['limit'] ?? 1000;

            $query      = self::select('id','bank_id','name');

            if(!empty($params['bank_id'])){
                $query->where('bank_id',$params['bank_id']);
            }

            $results = $query->orderBy('name','desc')->limit($limit)
                        ->get();
        }
        return $results;
    }
}
