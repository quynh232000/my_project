<?php

namespace App\Models\Ecommerce;

use App\Models\Admin\UserModel;
use App\Models\AdminModel;

class CategoryModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
    }
    protected $guarded       = [];
    public function creator()
    {
        return   $this->belongsTo(UserModel::class, 'created_by', 'id');
    }
}
