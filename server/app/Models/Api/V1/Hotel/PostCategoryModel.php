<?php

namespace App\Models\Api\V1\Hotel;

use App\Models\ApiModel;
use Illuminate\Support\Facades\DB;
use Kalnoy\Nestedset\NodeTrait;

class PostCategoryModel extends ApiModel
{
    use NodeTrait;
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_POST_CATEGORY;
        parent::__construct();
    }
    protected $appends = [];
    public function listItem($params = null, $options = null)
    {

        $limit                  = $params['limit'] ?? 10;
        if ($options['task'] == 'list') {


            $query              = self::select('name', 'id', 'slug', 'image')
                ->where('status', 'active');

            // nếu có slug thì lấy danh mục con theo slug đó, ngược lại lấy danh mục root
            if (isset($params['slug']) && !empty($params['slug'])) {
                $query->WhereIn('id', function ($subQuery) use ($params) {
                    $subQuery->select('id')
                        ->from(TABLE_HOTEL_POST_CATEGORY)
                        ->whereIn('parent_id', function ($innerQuery) use ($params) {
                            $innerQuery->select('id')
                                ->from(TABLE_HOTEL_POST_CATEGORY)
                                ->where('slug', $params['slug']);
                        });
                });
            } else {
                $query->whereNull('parent_id');
            }

            // Trả kèm danh sách bài viết
            if (isset($params['with_items']) && $params['with_items'] == true) {
                $paramsNews             = [...$params, 'controller' => 'post'];

                $query->with([
                    'items' => function ($query) use ($params, $limit) {
                        $query->select('id', 'name', 'slug', 'created_at', 'category_id', 'created_by', 'image')
                            ->with(['author:id,full_name,avatar'])
                            ->where('status', 'active')
                            ->orderBy('priority', 'desc')
                            ->orderBy('updated_at', 'desc')
                            ->limit($limit);
                    }
                ]);
            }

            // Kết quả
            $items  = $query->orderBy('updated_at', 'desc')->get();
            return [
                'status'        => true,
                'status_code'   => 200,
                'message'       => 'Lấy bài viết tin tức thành công.',
                'data'          => $items,
            ];
        }
    }
    public function getItem($params = null, $options = null)
    {
        if ($options['task'] == 'get-item') {


            $item               = self::select('id', 'name', 'slug', 'image', 'description', 'content', 'parent_id', 'image')
                ->where('slug', $params['slug'])
                ->where('status', 'active');

            if (!empty($params['domain'])) {
                $domain         = self::where('name', $params['domain'])->first();
                if ($domain) {
                    $item->whereDescendantOf($domain);
                }
            }
            $item               = $item->first();

            if (isset($params['all_parent']) && $params['all_parent'] == true && $item) {
                $item->all_parent = $item->all_parent();
            }
            return $item;
        }
        if ($options['task'] == 'get-item-detail') {
            if (!isset($params['slug']) || empty($params['slug'])) {
                return [
                    'status'        => true,
                    'status_code'   => 200,
                    'message'       => 'Vui lòng nhập giá trị cho slug.',
                    'data'          => null
                ];
            }


            // Lấy các columns theo yêu cầu
            $columnsAccept      = ['name', 'id', 'slug', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
            $columnsSelect      = ['name', 'id', 'slug', 'image', 'parent_id'];

            if (isset($params['columns']) && is_array($params['columns']) && $params['columns'] > 0) {
                $columnsSelect  = array_merge($columnsSelect, array_intersect($params['columns'], $columnsAccept));
            } else {
                array_push($columnsSelect, 'description');
            }

            $item               = self::select($columnsSelect)
                ->where('slug', $params['slug'])
                ->where('status', 'active');
            if ($params['category_slug'] ?? false) {
                $item->whereHas('parent', fn($q) => $q->where('slug', $params['category_slug']));
            }

            $item = $item->first();


            if (!$item) {
                return [
                    'status'        => true,
                    'status_code'   => 200,
                    'message'       => 'Không tìm thấy thông tin danh mục với slug: ' . $params['slug'],
                    'data'          => null
                ];
            }
            // Lấy tất cả danh mục cha
            if (isset($params['all_parent']) && $params['all_parent'] == true) {
                $item->all_parent = $item->all_parent();
            }
            return [
                'status'            => true,
                'status_code'       => 200,
                'message'           => 'Lấy thông tin chi tiết thành công.',
                'data'              => $item
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
    public function items()
    {
        return $this->hasMany(PostModel::class, 'category_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(PostCategoryModel::class, 'parent_id', 'id')->select('id', 'name', 'slug', 'parent_id');
    }

    public function all_parent()
    {
        return PostCategoryModel::ancestorsOf($this->id)->select('id', 'name', 'slug');
    }
    public function child_ids()
    {
        return PostCategoryModel::descendantsOf($this->id)->pluck('id');
    }
}
