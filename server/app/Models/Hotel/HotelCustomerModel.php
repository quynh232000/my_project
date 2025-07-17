<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
class HotelCustomerModel extends AdminModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_HOTEL_CUSTOMER;

        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {

        $this->_data['status'] = false;

        if ($options['task'] == "admin-index") {

        }
        return $this->_data;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') { //thêm mới

            $data       = [];
            foreach ($params as $key    => $value) {
                $data[] = [
                    'hotel_id'          => $options['insert_id'],
                    'customer_id'       => $value,
                    'role'              => $options['role'] ?? 'manager'
                ];
            }
            self::insert($data);

        }
        if ($options['task'] == 'edit-item') { //cập nhật
            foreach ($params as $key => $value) {
                self::where(['hotel_id' => $options['insert_id'],'customer_id' => $key])->update(
                    $this->prepareParams($value)
                );
            }
        }
        if ($options['task'] == 'add-item-customer') { // thêm mới
            $data       = [];
            foreach ($params as $key => $value) {
                $data[] = [
                    'hotel_id'          => $value,
                    'customer_id'       => $options['insert_id'],
                    'role'              => $options['role'] ?? 'manager'
                ];
            }
            self::insert($data);
        }
        if ($options['task'] == 'edit-item-customer') { //cập nhật
            foreach ($params as $key => $value) {
                self::where(['customer_id' => $options['insert_id'],'hotel_id' => $key])->update(
                    $this->prepareParams($value)
                );
            }
        }

    }
    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item-info') {
        }
        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if(count($params ?? []) > 0){
                self::whereNotIn('id',$params)->where('hotel_id',$options['insert_id'])->delete();
            }else{
                self::where('hotel_id',$options['insert_id'])->delete();
            }
        }
        if ($options['task'] == 'delete-item-customer') {
            if(count($params ?? []) > 0){
                self::whereNotIn('id',$params)->where('customer_id',$options['insert_id'])->delete();
            }else{
                self::where('customer_id',$options['insert_id'])->delete();
            }
        }
    }

}
