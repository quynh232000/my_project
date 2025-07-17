<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use DB;

class HotelServiceModel extends HmsModel
{
    protected $bucket       = 's3_hotel';
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_HOTEL_SERVICE;
        parent::__construct();
        $this->bucket       = config('filesystems.disks.'.$this->bucket.'.driver').'_'.config('filesystems.disks.'.$this->bucket.'.bucket');
    }
    protected $hidden = ['parent_id','pivot'];
    public function listItem($params = null, $options = null)
    {

        if ($options['task'] == 'list-item') {

            $params['point_id']     = $params['type'] == 'hotel' ? auth('hms')->user()->current_hotel_id : $params['point_id'];
            $fieldSelect            = ['id','name','parent_id'];

            $filterHotelService     = function ($query) use ($params) {
                                            $query->where([
                                                'type'     => $params['type'],
                                                'point_id' => $params['point_id'],
                                            ]);
                                        };
            
            $data   = ServiceModel::select($fieldSelect)
                        ->with([
                            'children' => fn($query) => $query->select($fieldSelect)->whereHas('hotel_service', $filterHotelService)
                        ])
                        ->whereNull('parent_id')
                        ->where('type', $params['type'])
                        ->where('status', 'active')
                        ->whereHas('children', fn($query) => $query->whereHas('hotel_service', $filterHotelService))
                        ->get();
            return [
                'status'    => true,
                'data'      => $data
            ];
        }
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'edit-item') {

            $params['point_id']     = $params['type'] == 'room' ? $params['point_id'] : auth('hms')->user()->current_hotel_id;

            if(count($params['ids'] ?? []) == 0){
                $this->deleteItem($params,['task' => 'delete-item-all']);   
            }else{
                $data       = [];
                $id_olds    = self::where(['type' => $params['type'],'point_id' => $params['point_id']])->pluck('service_id')->all();

                // insert new
                $id_news    = array_diff($params['ids'], $id_olds);
                // delete not in array ids
                $id_deletes = array_diff($id_olds, $params['ids']);

                if(count($id_deletes) > 0){
                    $params['ids'] = $id_deletes;
                    $this->deleteItem($params,['task' => 'delete-item']); 
                }

                $data       = [];
                foreach($id_news as $id){
                    $data[] = [
                        'service_id'    => $id,
                        'type'          => $params['type'], 
                        'point_id'      => $params['point_id']
                    ];
                }
                if(count($data) > 0){
                    self::insert($data);
                }
            }
        }
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item-all') {
            self::where(['type' => $params['type'],'point_id' => $params['point_id']])
                    ->delete();
        }
        if ($options['task'] == 'delete-item') {
            self::where(['type' => $params['type'],'point_id' => $params['point_id']])
                    ->whereIn('service_id',$params['ids'])
                    ->delete();
        }
    }
}
