<?php

namespace App\Models\Api\V1\Hotel;

use App\Models\Admin\UserModel;
use App\Models\ApiModel;
use App\Models\User;
use DB;

class PostModel extends ApiModel
{
    public function __construct()
    {
        $this->table         = TABLE_HOTEL_POST;
        parent::__construct();
    }
    protected $fillable = ['id'];
    protected $casts = [
        'benefit'   => 'array'
    ];
    protected $appends = [];

    public function listItem($params, $options = null)
    {
        $limit  = $params['limit'] ?? 10;

        $PostCategoryModel   = new PostCategoryModel();
        if ($options['task'] == 'list') {


            $query              = self::select('id', 'name', 'slug', 'created_at', 'category_id', 'created_by', 'image')
                ->with(['author:id,full_name,avatar', 'category:id,slug,name'])
                ->where(['status' => 'active']);
            // Lấy bài viết nổi bật
            if (isset($params['type']) && $params['type'] == 'featured') {
                $query->where(['featured' => 1]);
            } else {
                // Lấy bài viết theo danh mục
                if (!isset($params['slug']) || $params['slug'] == '') {
                    return [
                        'status'        => false,
                        'status_code'   => 200,
                        'message'       => 'Vui lòng nhập slug danh mục.',
                        'data'          => null
                    ];
                }
                $category       = $PostCategoryModel->getItem($params, ['task' => 'get-item']);
                if (!$category) {
                    return [
                        'status'        => false,
                        'status_code'   => 200,
                        'message'       => 'Danh mục không tồn tại.',
                        'data'          => null
                    ];
                }

                // lấy tất cả bài viết có trong danh mục tin tức cha
                if (!empty($category->parent_id)) {
                    $category_ids  = $category->child_ids();
                    $query->whereIn('category_id', [...$category_ids, $category['id']]);
                } else {
                    // chỉ lấy bài viết trong danh mục được chọn
                    $query->where(['category_id' => $category['id']]);
                }
            }

            $items  = $query->orderBy('priority', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate($limit);



            return [
                'status'      => true,
                'status_code' => 200,
                'message'     => 'Lấy bài viết tin tức thành công.',
                'data'        => [
                    'current_page' => $items->currentPage(),
                    'total_page'   => $items->lastPage(),
                    'total_item'   => $items->total(),
                    'per_page'     => $limit,
                    'list'         => $items->items(),
                    'category'     => $category ?? null
                ],
            ];
        }
    }

    public function getItem($params = null, $options = null)
    {
        if ($options['task'] == 'detail') {


            $query                  = self::select('id', 'name', 'slug', 'category_id', 'content', 'description', 'created_by', 'created_at', 'image', 'image')
                ->where('status', 'active');

            $withRelation           = ['author:id,full_name', 'category:id,name,slug,parent_id'];

            // Lấy hỏi đáp
            if (isset($params['faqs']) && $params['faqs'] == true) {
                $withRelation       =  array_merge($withRelation, ['faqs' => function ($query) {
                    $query->select('id', 'news_id', 'question', 'reply')
                        ->where('status', 'active');
                }]);
            }
            // Lấy bài viết liên quan
            if (isset($params['related']) && $params['related'] == true) {

                $withRelation       =  array_merge($withRelation, ['related' => function ($query) use ($params) {
                    $query->select('id', 'name', 'slug', 'created_at', 'category_id', 'created_by', 'image')
                        ->with(['author:id,full_name'])
                        ->where('status', 'active')
                        ->whereNot('slug', $params['data_value'])
                        ->orderBy('priority', 'asc')
                        ->orderByDesc('updated_at')
                        ->limit($params['limit'] ?? 5);
                }]);
            }
            $query->where('slug', $params['data_value']);
            // kiểm tra thuộc danh mục không
            if ($params['category_slug'] ?? false) {
                $query->whereHas('category', fn($q) => $q->where('slug', $params['category_slug']));
            }

            $query->with($withRelation);
            $item = $query->orderBy('priority', 'asc')
                ->orderByDesc('updated_at')->limit(1)->first();

            if (!$item) {
                return [
                    'status'        => true,
                    'status_code'   => 200,
                    'message'       => 'Bài viết không tồn tại.',
                    'data'          => null
                ];
            }
            // Lấy tất cả danh mục cha
            if (isset($params['all_parent']) && $params['all_parent'] == true) {
                $item->category->all_parent = $item->category->all_parent();
            }

            // Kết quả

            return [
                'status'      => true,
                'status_code' => 200,
                'message'     => 'Lấy bài viết thành công.',
                'data'        => $item
            ];
        }
        if ($options['task'] == 'meta') {
            $item = self::select('id', 'name', 'slug', 'meta_title', 'meta_description', 'meta_keyword')
                ->where('slug', $params['slug'] ?? '')
                ->where('status', 'active')
                ->first();
            if (!$item) {
                return  [
                    'status'        => false,
                    'status_code'   => 200,
                    'message'       => 'Không có bài viết hoặc xảy ra lỗi.',
                ];
            }
            return [
                'status'        => true,
                'status_code'   => 200,
                'message'       => 'Lấy thông tin Sale thành công.',
                'data'          => $item,
            ];
        }
    }
    public function category()
    {
        return $this->belongsTo(PostCategoryModel::class, 'category_id', 'id');
    }
    public function author()
    {
        return $this->belongsTo(UserModel::class, 'created_by', 'id');
    }
    public function related()
    {
        return $this->hasMany(PostModel::class, 'category_id', 'category_id');
    }
    // public function faqs()
    // {
    //     return $this->hasMany(NewsFaqsModel::class, 'news_id', 'id');
    // }
    public function getImageUrlAttribute()
    {
        return $this->attributes['image_url'] ?? null;
    }
}
