<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class ProvinceModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.general.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
}
