<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use Illuminate\Support\Facades\Storage;

class BookingDeputyModel extends HmsModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_BOOKING_DEPUTY;
        parent::__construct();
    }
    protected $casts        = [
                                'special_require' => 'array'
                            ]; 
    protected $hidden       = [
                                'created_by','created_at','updated_at','updated_by','ip'
                            ];
    protected $guarded      = [];

    public $crudNotAccepted = [];

    public function getItem($params = null, $options = null)
    {
        if ($options['task'] == 'detail') {
            
        }
       
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'index') {
            $hotel_id       = auth('hms')->user()->current_hotel_id;
            $query          = self::where('hotel_id',$hotel_id);

            $query->orderBy('created_at','desc');
            $results        = $query->paginate($params['limit'] ?? 10);

            return $results;
        }
    }
  
   
}
