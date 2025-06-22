<?php

namespace App\Models\Portfolio;

use App\Models\AdminModel;

class ContactModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.portfolio.' . self::getTable());
    }
    protected $casts = [

    ];
    protected $guarded      = [];

}
