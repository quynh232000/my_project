<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;

class HotelModel extends HmsModel
{
    protected $bucket  = 's3_hotel';

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_HOTEL;
        parent::__construct();
        $this->bucket       = 's3_hotel';
    }
    protected $casts = [
        'faqs' => 'array'
    ];
    protected $hidden = [
        'pivot',
        'contract_file'
    ];
    protected $guarded = [];

    public $crudNotAccepted = ['country_id', 'province_id', 'district_id', 'ward_id', 'address', 'longitude', 'latitude'];

    public function getItem($params = null, $options = null)
    {
        $results = null;

        if ($options['task'] == 'detail') {
            $results = self::with('location')->find(auth('hms')->user()->current_hotel_id);
            // dd(auth('hms')->user()->current_hotel_id);
            if ($results) {

                $locationFields = ['address', 'longitude', 'latitude', 'country_id', 'city_id', 'district_id', 'ward_id'];

                foreach ($locationFields as $field) {
                    $results->{$field} = optional($results->location)->{$field} ?? '';
                }

                unset($results->location);
            }
        }

        return $results;
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'index') {
            $hotel_ids      = auth('hms')->payload()->get('hotel_ids') ?? [];
            $results        = auth('hms')->user()->hotels ?? [];

            $result_ids     = $results->pluck('id')->toArray();

            $is_same        = empty(array_diff($hotel_ids, $result_ids)) && empty(array_diff($result_ids, $hotel_ids));

            if ($is_same) {
                $results    = $results->map(function ($item) {
                    $item->address = optional($item->location)->address ?? '';
                    // unset($item->location);
                    return $item;
                })->toArray();
                return [
                    'status'    => true,
                    'data'      => $results
                ];
            } else {
                return [
                    'status'    => false
                ];
            }
        }
    }

    public function saveItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'add-item') {
            $hotel_id = auth('hms')->user()->current_hotel_id;
            $hotel    = self::find($hotel_id);

            $params['updated_by']   = auth('hms')->id();
            $params['updated_at']   = date('Y-m-d H:i:s');

            if (request()->hasFile('image')) {
                $params['image']        = FileService::file_upload($params, $params['image'], 'thumbnail');
            }
            $LocationModel = new LocationModel();
            $LocationModel->saveItem($params, ['task' => 'add-item', 'insert_id' => $hotel_id]);

            unset($params['hotel_id']);
            // dd($this->prepareParams($params));
            $hotel->update($this->prepareParams($params));
        }

        return $results;
    }


    public function location()
    {
        return $this->hasOne(LocationModel::class, 'hotel_id', 'id');
    }
    public function policy_cancellations()
    {
        return $this->hasMany(PolicyCancellationModel::class, 'hotel_id', 'id')->where('status', 'active');
    }
    public function policy_others()
    {
        return $this->hasMany(PolicyOtherModel::class, 'hotel_id', 'id');
    }
    public function policy_generals()
    {
        return $this->hasMany(PolicyGeneralModel::class, 'hotel_id', 'id');
    }
    public function policy_children()
    {
        return $this->hasMany(PolicyChildrenModel::class, 'hotel_id', 'id')->orderBy('age_from', 'asc');
    }
}
