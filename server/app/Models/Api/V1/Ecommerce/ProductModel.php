<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;
use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProductModel  extends ApiModel
{
    use  SoftDeletes, HasFilters;
     private $filter_products = [];
    protected $appends = ['product_loves_count', 'product_reviews_count', 'shop_replies_count'];
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
     protected $guarded       = [];
    public function listItem($params = null, $options = null)
    {
        if ($options['task'] == "list") {

            $filter_products = [
                [
                    'relation' => 'brand',
                    'column' => 'id',
                    'value' => $params['brand'] ?? null,
                ],
                [
                    'relation' => 'category',
                    'column' => 'id',
                    'value' => $params['category'] ?? null,
                ],
                [
                    'column' => 'price',
                    'value' => $params['range'] ?? null,
                ],
                [
                    'column' => 'name',
                    'value' => $params['name'] ?? null,
                ],
            ];
            $limit          = request('limit', 20);
            $page           = request('page', 1);
            $sort_by        = request('sort_by', 'name');
            $sort_direction = request('sort_direction', 'asc');

            $query          = self::select('id', 'name', 'slug', 'image', 'price', 'percent_sale', 'origin', 'category_id')
                ->where([
                    ['deleted_at', '=', null],
                    ['status', '=', 'active'],
                    ['is_published', '=', 1],
                ]);


            if (isset($params['type']) && $params['type'] == 'flashsale') {
                $query->where('percent_sale', '>=', 40);
            }

            $products = $query->whereColumn('stock', '>', 'sold')
                ->filterAndSort($filter_products, $sort_by, $sort_direction)
                ->with('category:id,name')
                ->paginate($limit, ['*'], 'page', $page);

            $products->getCollection()->transform(function ($item) {
                $item->stars = $item->stars();
                return $item;
            });

            return $products;
        }

        if ($options['task'] == 'filter') {
            $category_id        = $params['category_id'] ?? null;
            $category_slug      = $params['category_slug'] ?? null;

            $TABLE_PRODUCT_REVIEW = config('constants.table.ecommerce.TABLE_PRODUCT_REVIEW');

            $productQuery       = self::where(['deleted_at' => null, 'status' => 'active', 'is_published' => 1])
                ->with('category', 'brand')
                ->addSelect([
                    $this->table . '.*',
                    DB::raw('(SELECT AVG(' . $TABLE_PRODUCT_REVIEW . '.star)
                                            FROM ' . $TABLE_PRODUCT_REVIEW . ' WHERE
                                            ' . $TABLE_PRODUCT_REVIEW . '.product_id = ' . $this->table . '.id AND ' . $TABLE_PRODUCT_REVIEW . '.is_hidden = 0) as stars')
                ]);
            // has slug shop
            if (isset($params['shop_slug']) && !empty($params['shop_slug'])) {
                $shop_slug      = $params['shop_slug'];
                $shop           = ShopModel::where('slug', $shop_slug)->first();
                if (!$shop) {
                    return false;
                }
                $isPageShop     = true;
                $productQuery->where('shop_id', $shop->id);
            }
            //  if has category _slug
            if (!is_null($category_id) || !is_null($category_slug)) {
                if (is_null($category_slug)) {
                    $category_detail    = CategoryModel::with('allChildren')->find($category_id);
                    if (!$category_detail) {
                        return $this->errorResponse("Not found", [], 400);
                    }
                } elseif (is_null($category_id)) {
                    $category_id_found  = CategoryModel::where('slug', $category_slug)->first();

                    if (!$category_id_found) {
                        return $this->errorResponse("Category not found", [], 400);
                    }
                    $category_id        = $category_id_found->id;

                    $category_detail    = CategoryModel::with('allChildren')->find($category_id_found->id);

                    if (!$category_detail) {
                        return $this->errorResponse("Not found", [], 400);
                    }
                }
                // get all category ids child
                if ($category_detail) {
                    $flat_category_id_child = self::extractIdFromCategory($category_detail);
                    $all_id                 = array_merge([(int) $category_id], $flat_category_id_child);
                    // query ids
                    $productQuery->whereIn('category_id', $all_id);
                }
            }
            if ($params['rating'] ?? false) {
                $productQuery->havingRaw('stars ' . $params['rating']);
            }

            if ($params['brand'] ?? false) {
                $productQuery->where('brand_id', $params['brand']);
            }

            if (($params['price_min'] ?? false) || ($params['price_max'] ?? false)) {
                $minPrice                   = $params['price_min'];
                $maxPrice                   = $params['price_max'];

                if (is_null($minPrice) || is_null($maxPrice)) {
                    return false;
                }

                if ($minPrice > $maxPrice) {
                    return false;
                }

                $productQuery->whereBetween('price', [$minPrice, $maxPrice]);
            }
            if (isset($params['type']) && $params['type'] == 'favourite') {
                $product_ids                = ProductLoveModel::where(['user_id' => auth('ecommerce')->id()])->pluck('product_id');
                $productQuery->whereIn('id', $product_ids);
            }

            if (isset($params['type']) && $params['type'] == 'search') {
                $search                     = $params['q'];
                $productQuery->where('name', 'LIKE', '%' . $search . '%');
            }
            if ($params['sortBy'] ?? false) {
                $sortBy         = $params['sortBy'];
                switch ($sortBy) {
                    case 'new':
                        // Sort by the most recent products (assuming `created_at` is the column for product creation date)
                        $productQuery->orderBy('created_at', 'desc');
                        break;

                    case 'sales':
                        // Sort by the sales, assuming you have a `sales_count` or similar column for the number of sales
                        $productQuery->orderBy('sold', 'desc');
                        break;

                    case 'price_desc':
                        // Sort by highest price, assuming `price` is the price column
                        $productQuery->orderBy('price', 'desc');
                        break;

                    case 'price_asc':
                        // Sort by lowest price
                        $productQuery->orderBy('price', 'asc');
                        break;

                    default:
                        // If no valid sortBy is provided, default sorting can be by something like creation date
                        $productQuery->orderBy('created_at', 'desc');
                        break;
                }
            }

            $limit      = $params['limit'] ?? 20;
            $page       = $params['page']  ?? 1;
            $data       = $productQuery->paginate($limit, ['*'], 'page', $page);

            // get all category

            if (isset($category_detail)) {
                $parent_cate    = $category_detail->parent_id == 0 ? $category_detail :
                    CategoryModel::find(explode(',', $category_detail->path)[0]);
                $cate           = $this->getAllChildren($parent_cate);
                $brand_detail   = BrandModel::whereIn('id', $productQuery
                    ->pluck('brand_id')->unique())->get();
                $dataResult     = [
                    'products'      => $data->items(),
                    'categories'    => [
                        'root'      => $parent_cate,
                        'children'  => $cate
                    ],
                    'brands'        => $brand_detail
                ];
            } else {
                $dataResult = $data->items();
            }
            return [
                $dataResult,
                $data
            ];
        }
    }
    public function getItem($params = null, $options = null)
    {
        $result         = null;
        if ($options['task'] == "info") {
            $slug       = $params['slug'] ?? null;
            if (!$slug || $slug == '') {
                return false;
            }
            $product    = self::where(['slug' => $slug, 'status' => 'active', 'is_published' => 1, 'deleted_at' => null])
                ->with('category:id,name,slug', 'brand:id,name',  'images', 'shipping', 'attributes.attribute_name', 'shop.user')
                ->first();

            if (!$product) {
                return false;
            }

            $product->is_loved      = $product->is_loved();
            $product->love_count    = $product->love_count();
            $product->review_count  = $product->review_count();
            $product->stars         = $product->stars();


            $categories             = array_merge($product->category->getAllParents()->toArray(), [$product->category->toArray()]);
            $shop                   = $product->shop;
            $shop->is_follow        = $shop->is_follow();
            $shop->follow_count     = $shop->follow_count();
            // dd(123);
            $shop->shop_dashboard   = $shop->shop_dashboard();

            $shop_vouchers          = $shop->activeVouchers();
            if (auth('ecommerce')->check()) {
                $my_review          = $product->my_review();
            }
            $TABLE_PRODUCT_REVIEW   = config('constants.table.ecommerce.TABLE_PRODUCT_REVIEW');
            // get product relative
            $type_product           = 'same_category';
            $data_products          = self::with('category', 'brand')->where(['category_id' => $product->category_id])
                ->where(
                    [
                        ['deleted_at', '=', null],
                        ['status', '=', 'ACTIVE'],
                        ['is_published', '=', 1]
                    ]
                )->whereNot('id', $product->id)
                ->addSelect([
                    $this->table . '.*',
                    DB::raw('(SELECT AVG(' . $TABLE_PRODUCT_REVIEW . '.star)
                                                FROM ' . $TABLE_PRODUCT_REVIEW . ' WHERE
                                                ' . $TABLE_PRODUCT_REVIEW . '.product_id = ' . $this->table . '.id AND ' . $TABLE_PRODUCT_REVIEW . '.is_hidden = 0) as stars')
                ])
                ->limit(10)->get();
            if ($data_products->count() == 0) {
                $data_products      = self::where(
                    [
                        ['deleted_at', '=', null],
                        ['status', '=', 'ACTIVE'],
                        ['is_published', '=', 1]
                    ]
                )->with('category', 'brand')->orderBy('sold', 'desc')->limit(10)
                    ->addSelect([
                        'products.*',
                        DB::raw('(SELECT AVG(' . $TABLE_PRODUCT_REVIEW . '.star)
                                                FROM ' . $TABLE_PRODUCT_REVIEW . ' WHERE
                                                ' . $TABLE_PRODUCT_REVIEW . '.product_id = ' . $this->table . '.id AND ' . $TABLE_PRODUCT_REVIEW . '.is_hidden = 0) as stars')
                    ])->get();
                $type_product       = 'suggestion';
            }

            return [
                'product'       => $product,
                'shop'          => $shop,
                'categories'    => $categories,
                'my_review'     => $my_review ?? null,
                'shop_vouchers' => $shop_vouchers,
                'data_products' => ['products' => $data_products, 'type' => $type_product]
            ];
        }
        return $result;
    }

    // filter
    static function extractIdFromCategory($category): array
    {
        $category_child_id = array();

        if ($category->allChildren) {
            foreach ($category->allChildren as $child) {
                $category_child_id[] = $child->id;
                if ($child->allChildren->isNotEmpty()) {
                    $recursive_ids = self::extractIdFromCategory($child);

                    foreach ($recursive_ids as $id) {
                        $category_child_id[] = $id;
                    }
                }
            }
        }
        return $category_child_id;
    }
    function getAllChildren($category)
    {
        $children = $category->children;

        foreach ($children as $child) {
            $children = $children->merge($this->getAllChildren($child));
        }

        return $children;
    }
    // filter

    public function category()
    {
        return $this->belongsTo(CategoryModel::class);
    }
    public function brand()
    {
        return $this->belongsTo(BrandModel::class);
    }
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function images()
    {
        return $this->hasMany(ProductImageModel::class, 'product_id', 'id');
    }
    public function shipping()
    {
        return $this->hasOne(ProductShippingModel::class, 'product_id', 'id');
    }
    public function attributes()
    {
        return $this->hasMany(ProductAttributeModel::class, 'product_id', 'id');
    }
    public function shop()
    {
        return $this->belongsTo(ShopModel::class, 'shop_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(ProductReviewModel::class, 'product_id', 'id');
    }
    public function latest_review()
    {
        return $this->reviews()->one()->latestOfMany();
    }
    public function review_metric()
    {
        return $this->hasOne(ProductReviewMetricModel::class,'product_id','id');
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLogModel::class,'product_id','id');
    }
    public function priceLogs()
    {
        return $this->hasMany(PriceLogModel::class,'product_id','id');
    }
    public function order_detail()
    {
        return $this->has(OrderDetailModel::class,'product_id','id');
    }
    public function loves()
    {
        return $this->hasMany(ProductLoveModel::class, 'product_id', 'id');
    }
    public function stars()
    {
        $avg = ProductReviewModel::where('product_id', $this->id)->avg('star');
        return $avg ? round($avg, 1) : 0;
    }

    public function is_loved()
    {
        if (auth('ecommerce')->check()) {
            $user_id    = auth('ecommerce')->id();
            $love       = ProductLoveModel::where('user_id', $user_id)->where('product_id', $this->id)->first();
            return $love ? true : false;
        } else {
            return false;
        }
    }
    public function love_count()
    {
        return ProductLoveModel::where('product_id', $this->id)->count() ?? 0;
    }
    public function my_review()
    {
        if (!auth('ecommerce')->check()) {
            return ['can_review' => false, 'review' => null];
        }
        $check_review = ProductReviewModel::where(['product_id' => $this->id, 'user_id' => auth('ecommerce')->id()])
            ->with('user', 'reply.shop', 'likes')->first();
        if ($check_review) {
            $check_review->is_like = ['like_status' => $check_review->is_like(), 'counting' => $check_review->likes_count];
            return ['can_review' => true, 'review' => $check_review];
        }
        $check_can_review = OrderDetailModel::where('product_id', $this->id)
            ->whereHas('OrderShop.Order', function ($query) {
                $query->where('status', 'COMPLETED')
                    ->where('user_id', auth('ecommerce')->id());
            })->exists();
        return ['can_review' => $check_can_review, 'review' => null];
    }
    public function review_count()
    {
        return ProductReviewModel::where('product_id', $this->id)->count() ?? 0;
    }
    public static function getStateProducts($state = null)
    {
        if (!$state) {
            return [];
        }
        switch ($state) {
            // 'PENDING','ACTIVE','DENY'
            case 'PENDING':
                return array(
                    [
                        'column' => 'status',
                        'value' => 'PENDING',
                    ]
                );
            case 'ACTIVE':
                return array(
                    [
                        'column' => 'status',
                        'value' => 'ACTIVE',
                    ]
                );
            case 'DENY':
                return array(
                    [
                        'column' => 'status',
                        'value' => 'DENY',
                    ]
                );
            case 'A-FEW-LEFT':
                return array(
                    [
                        'column' => 'stock',
                        'value' => 'to-10',
                    ]
                );
            /**
                 * case 'A-FEW-LEFT':
                 *     $products = self::with('inventoryLogs')->get();
                 *     $productIds = $products->filter(function ($product) {
                 *         $availableStock = $product->inventoryLogs->sum('inventory_adjustment') - $product->sold;
                 *         return $availableStock > 0 && $availableStock <= 0.1 * $availableStock;
                 *     })->pluck('id');

                 *     return [['column' => 'id', 'value' => $productIds->toArray()]];
                 */
            case 'HIDDEN':
                return array(
                    [
                        'column' => 'is_published',
                        'value' => 1,
                    ]
                );

            default:
                return [];
        }
    }
    public static function getInventory()
    {
        return self::with('inventoryLogs')->get();
    }
    /**
     * "star","comment","is_hidden","images","product_id","user_id","order_id","status",
     */

    protected $product_review_params = ["star", "comment", "is_hidden", "images", "product_id", "user_id", "order_id", "status",];
    /**
     * "uuid","full_name","username","email","phone_number","avatar_url","thumbnail_url","birthday","address","is_blocked","bio","failed_attempts","blocked_until","email_verified_at","created_at","updated_at"l
     */

    protected $product_review_user_params = ["uuid", "full_name", "username", "email", "phone_number"];
    /**
     * 'total_reviews','average_rating','rating_1_count','rating_2_count','rating_3_count','rating_4_count','rating_5_count','product_id',
     */
    protected $product_review_metric_params = ['total_reviews', 'average_rating', 'rating_1_count', 'rating_2_count', 'rating_3_count', 'rating_4_count', 'rating_5_count',];

    public function getFilters()
    {

        foreach (request()->all() as $column => $value) {

            if (in_array($column, ['limit', 'page', 'sort_by', 'sort_direction'])) {
                continue;
            }

            if (in_array($column, $this->product_review_params)) {
                $this->filter_products = $this->addFilter($column, $value, 'reviews');
            } else if (in_array($column, $this->product_review_user_params)) {
                $this->filter_products = $this->addFilter($column, $value, 'reviews.user');
            } else if (in_array($column, $this->product_review_metric_params)) {
                $this->filter_products = $this->addFilter($column, $value, 'review_metric');
            } else {
                $this->filter_products = $this->addFilter($column, $value);
            }
        }
        return $this->filter_products;
    }
    protected function addFilter($column, $value, $relation = null)
    {
        $this->filter_products[] = compact(['column', 'value', 'relation']);
        return $this->filter_products;
    }
    public function returnSold($quantity)
    {
        $this->sold -= $quantity;
        return $this->save();
    }
    /**
     * Product Model --> ERs' Helpers
     */

    public function getProductLovesCountAttribute()
    {
        return $this->loves()->count();
    }
    public function getProductReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
    public function getShopRepliesCountAttribute()
    {
        return ProductReviewReplyModel::whereIn('product_review_id', $this->reviews->pluck('id'))->count();
    }



    public function avgRating()
    {
        return $this->stars->avg('star');
    }
    public function getStock()
    {
        return $this->inventoryLogs()->sum('inventory_adjustment') - $this->sold;
    }

    public static function getERNames()
    {
        return ['category', 'brand', 'images', 'shipping', 'attributes.attribute_name', 'shop', 'inventoryLogs', 'priceLogs'];
    }
    public function getER()
    {
        return $this->with($this->getERNames());
    }
    public function getERData()
    {
        return $this->load($this->getERNames());
    }
    public function getReplicate()
    {
        $replicate = $this->load(['category', 'brand', 'images', 'shipping', 'attributes', 'shop',])->replicate();

        $replicate->save();

        return $replicate;
    }

}
