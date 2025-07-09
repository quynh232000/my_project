<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;

class PolicyCancelRuleModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_POLICY_CANCEL_RULE;
        parent::__construct();
    }
    protected $hidden = [
        'created_at', 'created_by', 'updated_at'
    ];
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-item') {

           
        }
        return $results;
    }
    public function saveItem($params = null, $options = null){
        if ($options['task'] == 'edit-item') {

            $dataInsert = [];
            $ids        = [];
            // dd($params);
            foreach ($params ?? [] as $item) {
                // if emtpy then create 
                if(empty($item['id'] ?? '')){

                    $dataInsert[] = [
                        ...$item,
                        'policy_cancel_id'      => $options['insert_id'], 
                        'day'                   => $item['day']  ? $item['day'] : 0,
                        'fee_type'              => $item['fee_type'],
                        'fee'                   => $item['fee_type'] == 'free' ? 0 : $item['fee'],
                        'created_at'            => date('Y-m-d H:i:s')
                    ];
                }else{
                // else update
                    $ids[]              = $item['id'];
                    self::where(['id' => $item['id'], 'policy_cancel_id' => $options['insert_id']])->update([
                        ...$item,
                        'fee_type'      => $item['fee_type'],
                        'fee'           => $item['fee_type'] == 'free' ? 0 : $item['fee'],
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                }
            }

            // delete item
            if(count($ids) > 0){
                self::where('policy_cancel_id', $options['insert_id'])->whereNotIn('id',$ids)->delete();
            }else{
                self::where('policy_cancel_id', $options['insert_id'])->delete();
            }
            if(count($dataInsert) > 0){
                self::insert($dataInsert);
            }
           
        }

    }
    public function getItem($params = null, $options = null){
        if ($options['task'] == 'item-info') {

        }

    }
    public function deleteItem($id, $options = null){
        if ($options['task'] == 'delete-all') {
            self::where(['policy_cancel_id' => $id])->delete();
        }

    }
}
