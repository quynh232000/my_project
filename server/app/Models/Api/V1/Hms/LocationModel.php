<?php

namespace App\Models\Api\V1\Hms;

use App\Models\Api\V1\General\CityModel;
use App\Models\Api\V1\General\CountryModel;
use App\Models\Api\V1\General\DistrictModel;
use App\Models\Api\V1\General\WardModel;
use App\Models\HmsModel;

class LocationModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_LOCATION;
        parent::__construct();
    }
    protected $hidden = [
        'created_at','created_by','updated_at','updated_by'
    ];
    public function getItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'get-item') {

           
           
        }
        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        if($options['task'] == 'add-item') {
             $dataInsert = [
                            ...$this->getAddressInfo($params),
                            'address'      => $params['address'] ?? '',
                            'longitude'    => $params['longitude'] ?? '',
                            'latitude'     => $params['latitude'] ?? '',
                            'updated_by'   => auth('hms')->user()->id,
                            'updated_at'   => date('Y-m-d H:i:s'),
                            'hotel_id'     => $options['insert_id'],
                        ];

            self::updateOrInsert([
                'hotel_id' => $options['insert_id'],
            ], $dataInsert);
        }
    }

    public function getAddressInfo($params)
    {
        $data       = [];

        $models     = [
                        'country'  => CountryModel::class,
                        'city'     => CityModel::class,
                        'district' => DistrictModel::class,
                        'ward'     => WardModel::class,
                    ];

        foreach ($models as $key => $model) {

            $idKey  = "{$key}_id";

            if (!empty($params[$idKey])) {

                $record = $model::find($params[$idKey]);

                if ($record) {
                    $data[$idKey]        = $record->id ?? '';
                    $data["{$key}_name"] = $record->name ?? '';
                    $data["{$key}_slug"] = $record->slug ?? '';
                }
            }
        }

        return $data;
    }
}
