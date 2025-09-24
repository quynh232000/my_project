<?php

namespace App\Models\General;

use App\Models\AdminModel;
class FileUploadModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.general.'.self::getTable());
    }
    protected $guarded       = [];
    public function user(){
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
}
