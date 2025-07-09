<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
class NearbyLocationModel extends AdminModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_NEARBY_LOCATION;
        parent::__construct();
    }

    public function listItem($params = null, $options = null)
    {
        $data = [];
        if ($options['task'] == "list-by-hotel") {
           $data = self::where('hotel_id',$params['id'])->select(['id','name','address','latitude','longitude','distance'])->get()->toArray();
        }
        return $data;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') { //thêm mới
            foreach ($params as $key => $value) {
                $params[$key]['created_by']  = Auth::user()->id;
                $params[$key]['created_at']  = date('Y-m-d H:i:s');
                $params[$key]['hotel_id']    = $options['insert_id'];
                $params[$key]['distance']    = $this->calculateDistance($options,$value);
            }
            if(count($params ?? []) >0 ){
                self::insert($this->prepareParams($params));
            }
            return true;
        }
        if ($options['task'] == 'edit-item') { //cập nhật
            foreach (($params ?? []) as $key => $value) {
                $value['updated_at'] = now();
                $value['updated_by'] = Auth::user()->id;
                $value['distance']   = $this->calculateDistance($options,$value);
                self::where('id',$key)->update($this->prepareParams($value));
            }
            return true;
        }
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item-info') {
            $result = self::select($this->table . '.*')
                ->where('id', $params['id'])->first()->toArray();
        }
        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-items') {
            if(count($params) > 0){
                self::where('hotel_id',$options['insert_id'])->whereNotIn('id', $params)->delete();
            }
        }
    }
        public function calculateDistance($options, $value) {
        $earthRadius    = 6371; // Bán kính Trái Đất (km)
        $lat1           = $options['lat'];
        $lng1           = $options['lng'];

        $lat2           = $value['latitude'];
        $lng2           = $value['longitude'];

        $dLat           = deg2rad($lat2 - $lat1);
        $dLon           = deg2rad($lng2 - $lng1);

        $a              = sin($dLat / 2) * sin($dLat / 2) +
                        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                        sin($dLon / 2) * sin($dLon / 2);

        $c              = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c * 1000; // Đơn vị mét
    }
    public static function formatDistance($distance) {
        if ($distance >= 1000) {
            return number_format($distance / 1000, 1) . ' km';
        } else {
            return number_format($distance, 0) . ' m';
        }
    }
}
