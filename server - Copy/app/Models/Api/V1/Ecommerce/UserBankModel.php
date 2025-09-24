<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class UserBankModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
    public function bank()
    {
        return $this->belongsTo(DistrictModel::class, 'bank_id', 'id');
    }
}
