<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class PostModel  extends ApiModel
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

            $page           = $params['page'] ?? 1;
            $limit          = $params['limit'] ?? 10;

            $post_type_id   = PostTypeModel::where(['name' => strtoupper($params['post_type'])])->pluck('id')->first();
            $category_ids   = CategoryPostModel::where('post_type_id', $post_type_id)->pluck('id')->all();

            $query          = self::select('id', 'thumbnail','slug', 'title', 'content','created_at','author_id','category_post_id')
                            ->where(['is_published' => 1, 'is_show' => 1, 'deleted_at' => null])
                            ->where('status', 'active')
                            ->with('author', 'category');


            if ($params['category'] ?? false) {
                $category   = CategoryPostModel::where('slug', $params['category'])->pluck('id')->first();

                if ($category) {
                    $query->where('category_post_id', $category);
                } else {
                    return false;
                }
            } else {
                $query->whereIn('category_post_id', $category_ids);
            }
            if ($params['tag_id'] ?? false) {
                $post_ids = PostTagRelationModel::where('tag_id', $params['tag_id'])->pluck('post_id')->all();
                $query->whereIn('id', $post_ids);
            }

            if ($params['search'] ?? false) {
                $query->where('title', 'like', '%' . $params['search'] . '%')
                    ->orWhere('content', 'like', '%' . $params['search'] . '%');
            }
            $result = $query->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page);

            return $result;
        }
    }
    public function tags()
    {
        return $this->belongsToMany(TagModel::class, 'tag_post_relations', 'post_id', 'tag_id')
            ->as('tag_post_relation');
    }
    public function author()
    {
        return $this->belongsTo(UserModel::class, 'author_id','id');
    }
    public function category()
    {
        return $this->belongsTo(CategoryPostModel::class, 'category_post_id','id');
    }
    public function post_tags()
    {
        return $this->hasMany(PostTagRelationModel::class, 'post_id','id');
    }
}
