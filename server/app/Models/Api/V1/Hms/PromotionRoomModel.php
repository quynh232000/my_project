<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PromotionRoomModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PROMOTION_ROOM;
        parent::__construct();
    }
    protected $guarded      = [];
    protected $hidden       = ['created_at', 'created_by', 'updated_at'];
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

           
        }
       
        return $results;
    }
    public function saveItem($params = null, $options = null){
        $result                         = null;

        if ($options['task'] == 'add-item') {
            $data                       = [];
            foreach ($params as $id) {
                 $data[]                = [
                                            'room_id'          => $id,
                                            'promotion_id'     => $options['insert_id']
                                        ];
            }
            self::insert($data);
        }
        if ($options['task'] == 'edit-item') {

            $idOlds      = self::where('promotion_id',$options['insert_id'])->pluck('room_id')->all();
            $idDeletes   = array_diff($idOlds,$params);
            $idAdds      = array_diff($params,$idOlds);
 
            if(count($idDeletes) > 0){
             self::deleteItem($idDeletes,[...$options, 'task' => 'delete-item']);
            }
            if(count($idAdds) > 0){
             self::saveItem($idAdds,[...$options, 'task' => 'add-item']);
            }
          }
         return $result;
     }
     public function deleteItem($ids, $options = null){
         if ($options['task'] == 'delete-item') {
             self::where('promotion_id',$options['insert_id'])->whereIn('room_id',$ids)->delete();   
         }
     }
}
