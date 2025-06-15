<?php

namespace App\Models\Admin;

use App\Models\AdminModel;
class UserPermissionModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.general.'.self::getTable());
    }
    protected $guarded       = [];
}
