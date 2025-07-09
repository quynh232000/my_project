<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class BankModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_BANK;
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

            $limit      = $params['limit'] ?? 1000;

            $results    = self::select('id','name','code','short_name')
                        ->with(['branchs' => function ($q)  {
                            $q->select('id','name','address','bank_id');
                        }])
                        ->where('status','active')
                        ->limit($limit)
                        ->get();
        }
        return $results;
    }
    public function branchs() {
        return $this->hasMany(BankBranchModel::class,'bank_id','id');
    }
}
