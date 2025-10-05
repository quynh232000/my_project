<?php

namespace App\Models\Api\V1\Cms;

use App\Models\HmsModel;
use App\Traits\ApiResponse;



class MenuPriceModel extends HmsModel
{
    use ApiResponse;
    public function __construct()
    {
        $this->table        = TABLE_CMS_MENU_PRICE;
        parent::__construct();
    }

    public $crudNotAccepted         = [];
    protected $guarded              = [];
    protected $hidden = ['updated_at','updated_by','created_at','created_by'];
  
    public function menu_item()
    {
        return $this->belongsTo(MenuOptionModel::class, 'menu_item_id', 'id');
    }

}
