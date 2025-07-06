<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class PasswordResetTokenModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.general.TABLE_PASSWORD_RESET_TOKEN');
        parent::__construct();
    }
    protected $guarded       = [];
}
