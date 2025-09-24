<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class ProductAttributeModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    public function attribute_name(){
        return $this->belongsTo(AttributeNameModel::class, 'attribute_name_id', 'id');
    }

}
