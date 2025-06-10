<?php

namespace App\Models\Admin;

use App\Models\AdminModel;
class OrganizationModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.general.TABLE_ORANIZATION');
    }
    protected $guards       = [];
}
