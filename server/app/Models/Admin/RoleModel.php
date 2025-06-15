<?php

namespace App\Models\Admin;

use App\Models\AdminModel;
class RoleModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
         $this->table        = config('constants.table.general.'.self::getTable());
    }
    protected $guarded       = [];
    public function permissions(){
        return $this->belongsToMany(PermissionModel::class,config('constants.table.general.TABLE_ROLE_PERMISSION'),'role_id','permission_id');
    }
    public function user_roles()
    {
        return $this->hasMany(UserRoleModel::class,  'role_id', 'id');
    }
}
