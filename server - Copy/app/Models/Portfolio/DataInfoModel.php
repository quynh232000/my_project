<?php

namespace App\Models\Portfolio;

use App\Models\Admin\UserModel;
use App\Models\AdminModel;

class DataInfoModel  extends AdminModel
{


    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.portfolio.' . self::getTable());
    }
    protected $casts = [
        'socials'       => 'array',
        'languages'     => 'array',
        'skills'        => 'array',
        'extra_skills'  => 'array',
        'reviews'       => 'array',
        'educations'    => 'array',
        'awards'                => 'array',
        'work_experience'       => 'array',
    ];
    protected $guarded      = [];
    public function creator()
    {
        return   $this->belongsTo(UserModel::class, 'created_by', 'id');
    }
}
