<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class LiveChatModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
    public function user() {
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
}
