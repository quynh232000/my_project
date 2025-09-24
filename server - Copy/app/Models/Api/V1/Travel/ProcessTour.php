<?php

namespace App\Models\Api\V1\Travel;

use App\Models\ApiModel;

class ProcessTour extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.travel.' . self::getTable());
        parent::__construct();
    }
    protected $fillable = [
        'product_id',
        'date',
        'title',
        'content'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
