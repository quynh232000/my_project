<?php

namespace App\Models\Hotel;
use App\Models\Api\V1\General\CityModel;
use App\Models\AdminModel;
use App\Models\General\CountryModel;
use App\Models\General\DistrictModel;
use App\Models\General\WardModel;
use Illuminate\Support\Facades\Auth;

class LocationModel extends AdminModel
{
    protected $guarded = ['id'];

    public function __construct($attributes = [])
    {
        $this->table        = TABLE_HOTEL_LOCATION;
        $this->attributes   = $attributes;
        parent::__construct();
    }

    public function getItem($params = null, $options = null){

        if ($options['task'] == "get-item") {

            $this->_data['item']   = self::where('hotel_id', $params['hotel_id'])->first();

        }
        return $this->_data;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {

            $dataInsert = [
                            ...$this->getAddressInfo($params),
                            'address'      => $params['address'] ?? '',
                            'longitude'    => $params['longitude'] ?? '',
                            'latitude'     => $params['latitude'] ?? '',
                            'created_by'   => Auth::user()->id,
                            'created_at'   => date('Y-m-d H:i:s'),
                            'hotel_id'     => $options['insert_id'],
                        ];

            self::create($this->prepareParams($dataInsert));

        }
        if ($options['task'] == 'edit-item'){
            $dataInsert = [
                            ...$this->getAddressInfo($params),
                            'address'      => $params['address'] ?? '',
                            'longitude'    => $params['longitude'] ?? '',
                            'latitude'     => $params['latitude'] ?? '',
                            'updated_by'   => Auth::user()->id,
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
                    $data[$idKey]        = $record->id;
                    $data["{$key}_name"] = $record->name ?? '';
                    $data["{$key}_slug"] = $record->slug ?? '';
                }
            }
        }

        return $data;
    }
}
