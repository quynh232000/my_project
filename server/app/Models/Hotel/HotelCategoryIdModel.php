<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
class HotelCategoryIdModel extends AdminModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_HOTEL_CATEGORY_ID;
        parent::__construct();
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {

            $dataInsert     = [];

            foreach ($params ?? [] as $key => $value) {
                $dataInsert = [
                                'category_id'   => $value,
                                'hotel_id'      => $options['insert_id']
                            ];
            }
            self::insert($dataInsert);
        }
        if ($options['task'] == 'edit-item') {

            self::where('hotel_id',$options['insert_id'])->whereNotIn('category_id',$params)->delete();

            $dataInsert         = [];

            foreach ($params ?? [] as $key => $value) {
                $dataInsert[]   = [
                                    'category_id'   => $value,
                                    'hotel_id'      => $options['insert_id']
                                ];
            }
            self::upsert($dataInsert,['hotel_id','category_id'],['hotel_id','category_id']);
        }
    }
}
