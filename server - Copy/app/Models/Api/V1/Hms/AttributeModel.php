<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use Kalnoy\Nestedset\NodeTrait;

class AttributeModel extends HmsModel
{
    use NodeTrait;
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ATTRIBUTE;
        parent::__construct();
    }
    protected $hidden = ["status","created_at","created_by","updated_at","updated_by"];
    public function listItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'list-items') {

            $limit      = $params['limit'] ?? 1000;

            $query      = self::select('id','name','slug','parent_id');
            
            if($params['list_tree'] ?? false){

                $root   = self::where('slug',$params['type'])->first();
                $query->where('parent_id',$root->id)->with('children:id,name,slug,parent_id');

            }else{

                $query->where('parent_id',function($query) use($params){
                    $query->select('id')->from(TABLE_HOTEL_ATTRIBUTE)->where('slug', $params['type']);
                });
            }

            $results        = $query->where('status','active')
                            ->limit($limit)
                            ->get();
                        
        }
        return $results;
    }
    public function rooms(){
        return $this->hasMany(RoomModel::class,'type_id','id');
    }
    public function priceTypeRoom() {
        return $this->hasMany(PriceTypeRoomModel::class,'room_type_id','id');
    }
    public function priceTypes(){
        return $this->belongsToMany(PriceTypeModel::class, TABLE_HOTEL_PRICE_TYPE_ROOM, 'room_type_id', 'price_type_id');
    }
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function parents()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id','id');
    }
}
