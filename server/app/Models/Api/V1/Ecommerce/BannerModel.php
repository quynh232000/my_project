<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class BannerModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        if ($options['task'] == "list") {

            $query      = self::select('id','title','description','alt','link_to','banner_url','type')
                        ->where('status','active');

            if($params['shop_slug'] ?? false){
                $user_id    = ShopModel::where('slug',$params['slug'])->first()->user_id ?? null;
                if(!$user_id) return false;
                $query->where('user_id', $user_id);
            }
            if($params['type'] ?? false){
                $query->where('type', $params['type']);
            }
            if($params['placement'] ?? false){
                $query->where('placement', $params['placement']);
            }

            if($params['limit'] ?? false){
                $query->limit($params['limit'] ?? 12);
            }
            $result = $query->orderBy('priority', 'asc')->get();
            return $result;
        }
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
        }
        if ($options['task'] == 'edit-item') {

        }

    }

    public function children()
    {
        return $this->hasMany(CategoryModel::class, 'parent_id');
    }
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
    public function hasChild()
    {
        return CategoryModel::where('parent_id', $this->id)->exists() ?? false;
    }
    public function childCategories($id = null)
    {
        $id = $id == null ? $this->id : $id;
        $all = CategoryModel::where('parent_id', $id)->get() ?? [];
        return $all;
    }
    public function sameparent()
    {
        return CategoryModel::where('parent_id', $this->parent_id)->get() ?? [];
    }
    public function parent($id = null)
    {
        $id = $id == null ? $this->parent_id : $id;
        $parent = CategoryModel::where('id', $id)->first();
        return $parent;
    }
    public function getAllParents($id = null)
    {
        $parents = collect();
        $parent = $this->parent($id);
        while ($parent) {
            $parents->prepend($parent);
            $parent = $parent->parent();
        }
        return $parents ?? [];
    }
    public function products()
    {
        return $this->hasMany(ProductModel::class);
    }

}
