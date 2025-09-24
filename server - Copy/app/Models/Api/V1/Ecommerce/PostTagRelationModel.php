<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class PostTagRelationModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    public function post()
    {
        return $this->belongsTo(PostModel::class, 'post_id', 'id');
    }
    public function tag()
    {
        return $this->belongsTo(TagModel::class, 'tag_id', 'id');
    }
}
