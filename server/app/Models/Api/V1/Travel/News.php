<?php

namespace App\Models\Api\V1\Travel;

use App\Models\ApiModel;

class News extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.travel.' . self::getTable());
        parent::__construct();
    }
    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'content',
        'thumbnail',
        'likes',
        'is_show',
        'category',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
