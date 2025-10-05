<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use DB;

class ServiceModel extends HmsModel
{
    protected $bucket       = 's3_hotel';
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_SERVICE;
        parent::__construct();
        $this->bucket       = config('filesystems.disks.' . $this->bucket . '.driver') . '_' . config('filesystems.disks.' . $this->bucket . '.bucket');
    }
    protected $hidden       = ['pivot'];
    public function listItem($params = null, $options = null)
    {

        if ($options['task'] == 'list-items') {

            $fieldSelect    = ['id', 'name', 'parent_id'];

            $data           = self::select($fieldSelect)
                ->with(['children' => function ($query) use ($fieldSelect) {
                    $query->select($fieldSelect)->where('status', 'active');
                }])
                ->whereNull('parent_id')
                ->where('type', $params['type'])
                ->where('status', 'active')
                ->get();
            return [
                'status'    => true,
                'data'      => $data
            ];
        }
    }
    public function saveItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'add-item') {
            $hotel = auth('hms')->user()->hotel;

            $params['updated_by']   = auth('hms')->id();
            $params['updated_at']   = date('Y-m-d H:i:s');


            $hotel->update($this->prepareParams($params));
        }

        return $results;
    }
    // public function getImageAttribute()
    // {
    //     return $this->attributes['image'] ? URL_DATA_IMAGE . (explode('_',$this->bucket)[1]) . "/service/images/{$this->id}/{$this->attributes['image']}" : null;
    // }
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->select('id', 'name', 'parent_id');
    }
    public function hotel_service()
    {
        return $this->hasMany(HotelServiceModel::class, 'service_id', 'id');
    }
}
