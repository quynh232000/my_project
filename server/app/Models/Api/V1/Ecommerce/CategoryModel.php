<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class CategoryModel  extends ApiModel
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

            $query      = self::select('id','name','slug','icon_url','parent_id')
                        ->where('status','active');
            if($params['limit'] ?? false){
                $query->limit($params['limit'] ?? 12);
            }
            if($params['with-child'] ?? false){
                $result = $query->get()->map(function ($category) {
                            $category->haschild = $category->hasChild();
                            $category->allChildren;
                            return $category;
                        });
            }else{
                $result = $query->get();
            }

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
