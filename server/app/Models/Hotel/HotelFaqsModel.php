<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Str;

class HotelFaqsModel extends AdminModel
{
    protected $guarded = ['id'];
    public function __construct($attributes = [])
    {
        $this->table = TABLE_HOTEL_FAQS;
        $this->attributes = $attributes;
        parent::__construct();
    }
    public function getItem($params = null, $options = null){

        $result = null;

        if ($options['task'] == 'get-by-hotel') {

        }

        return $result;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
            foreach (($params ?? []) as $key => $value) {
                if(!empty($value['question']) && !empty($value['reply']) ){
                    $params[$key]['hotel_id']   = $options['insert_id'];
                    $params[$key]['created_by'] = Auth::user()->id;
                    $params[$key]['created_at'] = date('Y-m-d H:i:s');
                }else{
                    unset($params[$key]);
                }
            }
            if(count($params ?? []) > 0){
                self::insert($this->prepareParams($params));
            }
        }
        if($options['task'] == 'edit-item'){
            foreach ($params as $key => $value) {
                $record = self::where('id', $key)->first();
                if ($record && ($record->question !== $value['question'] || $record->reply !== $value['reply']) && !empty($value['question']) && !empty($value['reply'])) {// nếu dữ liệu mới thay đổi thì cập nhật
                    $record->update([
                        'question'   => $value['question'],
                        'reply'      => $value['reply'],
                        'updated_at' => now(),
                        'updated_by' => Auth::user()->id,
                    ]);
                }
            }
        }
    }
    public function listItem($params = null, $options = null){
        $result =[];
        if ($options['task'] == 'list-by-hotel') {
            $result = self::select('id','question','reply')->where('hotel_id',$params['id'])->get()->toArray();
        }
        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item'){
            if(count($params ?? [])>0){
                self::where('hotel_id',$options['insert_id'])->whereNotIn('id', $params)->delete();
            }else{
                self::where('hotel_id',$options['insert_id'])->delete();
            }
        }
    }
}
