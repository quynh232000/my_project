<?php

namespace App\Models\Portfolio;

use App\Models\Admin\UserModel;
use App\Models\AdminModel;

class ProjectModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.portfolio.' . self::getTable());
    }
    protected $casts = [
        'feature' => 'array',
        'category'=>'array'
    ];
    protected $guarded      = [];
    public function creator()
    {
        return   $this->belongsTo(UserModel::class, 'created_by', 'id');
    }
}
