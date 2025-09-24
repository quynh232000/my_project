<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class CategoryPostModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    public function post_type()
    {
        return $this->belongsTo(PostTypeModel::class,'post_type_id','id');
    }
}
