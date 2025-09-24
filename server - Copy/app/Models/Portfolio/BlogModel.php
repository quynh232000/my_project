<?php

namespace App\Models\Portfolio;

use App\Models\Admin\UserModel;
use App\Models\AdminModel;

class BlogModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.portfolio.' . self::getTable());
    }
    protected $casts = [
        'tags'       => 'array',
    ];
    protected $guarded      = [];
    public function creator()
    {
        return   $this->belongsTo(UserModel::class, 'created_by', 'id');
    }
}
