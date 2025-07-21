<?php

namespace App\Models\Api\V1\Travel;

use App\Models\ApiModel;

class TourSale extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.travel.' . self::getTable());
        parent::__construct();
    }
}
