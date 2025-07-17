<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class DateBasedPriceModel extends AdminModel
{
    public function __construct()
    {
        $this->table            = TABLE_HOTEL_DATE_BASED_PRICE;

        parent::__construct();
        //$this->_viewAction  = 'hotel.date-based-price.index';
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item-info') {
            $this->hotel = new HotelModel();
            $result = $this->hotel->getItem($params, ['task' => 'get-date-based-price']);

            // $result = self::select($this->table . '.id')
            // ->where($this->table . '.' . $this->columnPrimaryKey(), $params[$this->columnPrimaryKey()])->first();
            // if ($result != null) {
            //     $result             = $result->toArray();
            // }

        }
        if ($options['task'] == 'get-hotel') {

            // $hotel  = new HotelModel();
            // $result = $hotel->getItem($params, ['task' => 'get-all']);
        }
        return $result;
    }
    public function saveItem($params = null, $options = null){
        if ($options['task'] == 'add-item') {

            $currentDate        = Carbon::now();
            $startOfWeek        = $currentDate->startOfWeek(Carbon::MONDAY);
            $this->roomType     = new RoomTypeModel();

            if (isset($params['all_room_types']) && $params['all_room_types'] != 0) {
                $params['room_type_ids']    = $this->roomType->getItem($params, ['task' => 'get-room-type'])->pluck('id')->toArray();
                $check_room_type            = self::whereIn('room_type_id', $params['room_type_ids'])
                                                ->whereIn('price_type_id', [$params['inserted_id']])->get();
                $existingRoomTypeIds        = $check_room_type->pluck('room_type_id')->toArray();
                $params['room_type_ids']    = array_diff($params['room_type_ids'], $existingRoomTypeIds);
            } else {
                $check_room_type            = self::whereIn('room_type_id', $params['room_type_id'])
                                                ->whereIn('price_type_id', [$params['inserted_id']])->get();
                $existingRoomTypeIds        = $check_room_type->pluck('room_type_id')->toArray();
                $params['room_type_ids']    = array_diff($params['room_type_id'], $existingRoomTypeIds);
            }

            $result = [];
            foreach ($params['room_type_ids'] as $params['id']) {
                $room_type = $this->roomType->getItem($params, ['task' => 'get-item-info']);
                for ($i = 0; $i < 14; $i++) {
                    $day = $startOfWeek->copy()->addDays($i);
                    $result[] = [
                        'room_type_id'  => $room_type['id'],
                        'price_type_id' => $params['inserted_id'],
                        'price'         => $room_type['price_standard'],
                        'quantity'      => $room_type['quantity'],
                        'date'          => $day->format('Y-m-d'),
                        'created_by'    => Auth::user()->id,
                    ];
                }
            }
            self::insert($this->prepareParams($result));
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-capacity-price') {

            foreach ($params as $rules) {
               if ($rules['status'] == 'active') {
                    $params['date_based_price_id'][]    = self::where([
                        'room_type_id'      => $rules['room_type_id'],
                        'price_type_id'     => $rules['price_type_id']
                    ])->get()->pluck('id')->toArray();
               }

            }

            $this->capacityPrice = new CapacityPriceModel();
            $this->capacityPrice->saveItem($params, ['task' => 'add-item']);

            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
    }
    public function roomType()
    {
        return $this->belongsTo(RoomTypeModel::class, 'room_type_id');
    }
    public function priceType()
    {
        return $this->belongsTo(PriceTypeModel::class, 'price_type_id');
    }
    public function capacityPrices()
    {
        return $this->hasMany(CapacityPriceModel::class, 'date_based_price_id');
    }
}
