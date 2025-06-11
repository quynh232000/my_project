<?php

namespace App\Models\Admin;

use App\Models\AdminModel;
class RoleModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.general.TABLE_ROLE');
    }
    protected $guards       = [];
}
