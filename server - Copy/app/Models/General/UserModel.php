<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    public function __construct()
    {
        $this->table        = config('constants.table.general.TABLE_USER');
    }
}
