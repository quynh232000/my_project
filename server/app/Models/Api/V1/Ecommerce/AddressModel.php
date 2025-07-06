<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class AddressModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
    public function user(){
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
    public function province(){
        return $this->belongsTo(ProvinceModel::class,'province_id','id');
    }
    public function district(){
        return $this->belongsTo(DistrictModel::class,'district_id','id');
    }
    public function ward(){
        return $this->belongsTo(WardModel::class,'ward_id','id');
    }
}
