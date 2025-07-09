<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PolicyChildrenModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_POLICY_CHILDREN;
        parent::__construct();
    }
    protected $hidden = [
        'created_at', 'created_by', 'updated_at','deleted_at'
    ];
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

            $hotel_id   = auth('hms')->user()->current_hotel_id;

            if($params['max_age'] ?? false){
                return self::where(['hotel_id' => $hotel_id ,'type' => 'policy'])->max('age_to') ?? 0; 
            }
            $results    = self::where(['hotel_id' => $hotel_id ,'type' => 'policy'])
                        ->get();
        }
        return $results;
    }
    public function saveItem($params = null, $options = null){
        if ($options['task'] == 'edit-item') {
            $hotel_id   = auth('hms')->user()->current_hotel_id;
            $dataInsert = [];
            $ids        = [];

            $maxOldAge = self::where(['hotel_id' => $hotel_id ,'type' => 'policy'])->max('age_to') ?? 0;
            $maxNewAge = 0;
            
            foreach ($params['policies'] ?? [] as $item) {
                // if emtpy then create 
                $maxNewAge = max($maxNewAge, $item['age_to']);
                if(empty($item['id'] ?? '')){
                    $dataInsert[] = [
                        ...$item,
                        'fee'           => $item['fee_type'] == 'fee' ? 0 : $item['fee'] ?? 0,
                        'quantity_child'=> $item['fee_type'] == 'limit' ? $item['quantity_child'] : 0,
                        'hotel_id'      => $hotel_id, 
                        'created_by'    => auth('hms')->id(),
                        'created_at'    => date('Y-m-d H:i:s'),
                        'type'          => 'policy'
                    ];
                }else{
                    // else update
                    $ids[]              = $item['id'];

                    self::where(['hotel_id'=>$hotel_id,'id'=>$item['id']])->update([
                        ...$item,
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                }
            }
            // delete item
            if(count($ids) > 0){
                self::where(['hotel_id'=>$hotel_id,'type'=>'policy'])->whereNotIn('id',$ids)->delete();
            }else{
                self::where(['hotel_id'=>$hotel_id,'type'=>'policy'])->delete();
            }
           

            // Nếu max age thay đổi thì xóa chính sách bên loại giá
            if($maxNewAge != $maxOldAge){
                self::where(['hotel_id'=>$hotel_id,'type'=>'price_type'])
                    ->delete();
            }

            if(count($dataInsert) > 0){
                self::insert($dataInsert);
            }
        }

        // edit in price type
        if($options['task'] == 'edit-pricetype'){
            $hotel_id   = auth('hms')->user()->current_hotel_id;
            $dataInsert = [];
            $ids        = [];
            
            foreach ($params ?? [] as $item) {
                // if emtpy then create 
                if(empty($item['id'] ?? '')){

                    $dataInsert[] = [
                        ...$item,
                        'fee'           => $item['fee_type'] == 'fee' ? 0 : $item['fee'] ?? 0,
                        'quantity_child'=> $item['fee_type'] == 'limit' ? $item['quantity_child'] : 0,
                        'hotel_id'      => $hotel_id, 
                        'created_by'    => auth('hms')->id(),
                        'created_at'    => date('Y-m-d H:i:s'),
                        'type'          => 'price_type',
                        'price_type_id' => $options['insert_id']
                    ];
                }else{
                // else update
                    $ids[]              = $item['id'];

                    self::where(['hotel_id'=>$hotel_id,'id'=>$item['id']])->update([
                        ...$item,
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                }
            }

            // delete item
            if(count($ids) > 0){
                self::where(['hotel_id'=>$hotel_id,'type'=>'price_type','price_type_id'=>$options['insert_id']])->whereNotIn('id',$ids)->delete();
            }else{
                self::where(['hotel_id'=>$hotel_id,'type'=>'price_type','price_type_id'=>$options['insert_id']])->delete();
            }
            if(count($dataInsert) > 0){
                self::insert($dataInsert);
            }
        }

    }
    public function getItem($params = null, $options = null){
        if ($options['task'] == 'item-info') {

            $hotel_id = auth('hms')->user()->current_hotel_id;

            return self::select('policy_setting_id','is_allow')->where(['hotel_id'=>$hotel_id])->get();
        }

    }
    public function deleteItem($id, $options = null){
        if ($options['task'] == 'delete-item') {
            
            $hotel_id = auth('hms')->user()->current_hotel_id;
            self::where(['hotel_id'=>$hotel_id,'id' => $id])->delete();
        }

        // xoá tất cả chính sách trẻ em theo loại giá
        if ($options['task'] == 'delete-pricetype') {
            
            $hotel_id = auth('hms')->user()->current_hotel_id;
            self::where(['price_type_id' => $options['insert_id']])->delete();
        }
    }
}
