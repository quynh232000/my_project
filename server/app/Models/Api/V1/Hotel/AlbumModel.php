<?php

namespace App\Models\Api\V1\Hotel;

use App\Models\ApiModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class AlbumModel extends ApiModel
{
    public function __construct()
    {
        $this->table    = TABLE_HOTEL_ALBUMN;
        $this->hidden   = [];
        $this->appends  = [];

        parent::__construct();
    }

    public function hotel()
    {
        return $this->belongsTo(HotelModel::class, 'id', 'hotel_id');
    }
    // public function getImageAttribute($value)
    // {
    //     if ($this->type == 'room_type') {
    //         $id = $this->point_id;
    //     } else {
    //         $id = $this->hotel_id;
    //     }
    //     $folderPath     = URL_DATA_IMAGE . "hotel/hotel/images/" . $id . "/";
    //     return $folderPath . $value;
    // }
    public function label()
    {
        return $this->belongsTo(AttributeModel::class, 'label_id', 'id');
    }
}
