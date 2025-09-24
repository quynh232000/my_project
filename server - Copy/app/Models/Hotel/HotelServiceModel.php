<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Str;
class HotelServiceModel extends AdminModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_HOTEL_SERVICE;
        parent::__construct();
    }

    public function listItem($params = null, $options = null)
    {
        $result = null;
        if($options['task'] == 'list-facility-hotel'){
            $result = self::where('hotel_id',$params['id'])
                    ->leftJoin(TABLE_HOTEL_SERVICE,TABLE_HOTEL_SERVICE.'.id','=',$this->table.'.service_id')
                    ->select([
                        $this->table.'.id',
                        $this->table.'.service_id',
                        TABLE_HOTEL_SERVICE.'.parent_id',
                        TABLE_HOTEL_SERVICE.'.name',
                    ])
                    ->get()
                    ->toArray();
        }
        if($options['task'] == 'list-service-hotel'){
            $result = self::where('hotel_id', $params['id'])
                        ->leftJoin(TABLE_HOTEL_SERVICE, TABLE_HOTEL_SERVICE . '.id', '=', $this->table . '.service_id')
                        ->leftJoin(TABLE_HOTEL_SERVICE . ' as se', TABLE_HOTEL_SERVICE . '.parent_id', '=', 'se.id')
                        ->select([
                            'se.id',
                            'se.name',
                            \DB::raw('COUNT(se.id) as count')
                        ])
                        ->groupBy('se.id', 'se.name')
                        // ->distinct()
                        ->get()
                        ->toArray();
        }
        return $result;
    }
    public function getItem($params =  null, $options = null){
        $result =  null;
        if ($options['task'] == 'get-room-service') {
            $result = self::where($this->table . '.room_type_id', $params['item']['id'])->get()->pluck('service_id');
            if (!empty($result)) {
                $result = $result->toArray();
            }
        }
        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
            $created_at = now();
            $created_by = Auth::user()->id;
            $data = [];
            foreach ($params as $key => $value) {
                $data[] = [
                    'hotel_id'           => $options['insert_id'],
                    'service_id'         => $value,
                    'type'               => 'hotel',
                    'created_at'         => $created_at,
                    'created_by'         => $created_by
                ];
            }
            if(count($data)>0){
                self::insert($this->prepareParams($data));
            }
        }

        if ($options['task'] == 'add-room-service') {
            if(!empty($params['services'])){
                $result   = array_map(fn($value) => [
                    'hotel_id'      => $params['hotel_id'],
                    'room_type_id'  => $params['room_type_id'],
                    'type'          => 'room_type',
                    'service_id'    => $value
                ], $params['services']);
                self::insert($this->prepareParams($result));
                return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
            }

        }
        if ($options['task'] == 'edit-item') {
            $arrDB       = self::where('hotel_id',$options['insert_id'])->pluck('service_id')->all() ?? [];
            $idsDelete   = array_diff($arrDB,$params ?? []);
            $idsAdd      = array_diff($params ?? [],$arrDB);
            // delete
            self::whereIn('service_id',$idsDelete)->delete();
            // update
            $this->saveItem($idsAdd,[...$options,'task' => 'add-item']);
            return true;
        }
        if ($options['task'] == 'edit-room-service') {
            self::where($this->table . '.room_type_id', $params['room_type_id'])->whereNotIn('service_id', $params['services'])->delete();
            $toAdd      = array_diff($params['services'], json_decode($params['old_services']));
            $result     = array_map(fn($value) => [
                'hotel_id'      => $params['hotel_id'],
                'room_type_id'  => $params['room_type_id'],
                'type'          => 'room_type',
                'service_id'    => $value
            ],  $toAdd);
            self::insert($this->prepareParams($result));
        }

    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {
            } else {
                self::whereIn($this->primaryKey, $params['id'])->delete();
            }
        }
    }

}
