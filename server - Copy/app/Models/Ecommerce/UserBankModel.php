<?php

namespace App\Models\Ecommerce;

use App\Models\Admin\UserModel;
use App\Models\AdminModel;

class UserBankModel  extends AdminModel
{
    protected $table        = null;
    public function __construct($attributes = [])
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        $this->attributes   = $attributes;

        parent::__construct();
    }
    protected $guarded       = [];
    public function bank() {
        return $this->belongsTo(BankModel::class,'bank_id','id');
    }
    public function user(){
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
}
