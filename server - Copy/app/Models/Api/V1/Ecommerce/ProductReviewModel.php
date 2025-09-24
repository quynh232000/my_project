<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class ProductReviewModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
     public function user()
    {
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
    public function reply()
    {
        return $this->hasOne(ProductReviewReplyModel::class,'product_review_id','id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class,'product_id','id');
    }

    public function likes()
    {
        return $this->hasMany(ProductLikeReviewModel::class, 'product_review_id','id');
    }

    /**
     * Product Review Model --> ERs' helpers
     */
    protected static $ER_names = ['user', 'reply', 'product', 'likes',];
    public static function getERNames()
    {
        return self::$ER_names;
    }
    public function is_like()
    {
        $userId = auth('ecommerce')->check();
        if (!$userId) return false;
        return ProductLikeReviewModel::where(['user_id' => auth('ecommerce')->id(), 'product_review_id' => $this->id])->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }


    protected $product_params = ["slug", "name", "sku", "description", "price", "percent_sale", "origin", "status", "category_id", "brand_id", "stock", "sold", "view_count", "priority"];


    protected $user_params = ["uuid", "full_name", "username", "email", "phone_number"];

    public function getFilters()
    {
        foreach (request()->all() as $column => $value) {

            if (in_array($column, ['limit', 'page', 'sort_by', 'sort_direction'])) {
                continue;
            }

            if (in_array($column, $this->product_params)) {
                $this->filters = $this->addFilter($column, $value, 'product');
            } else if (in_array($column, $this->user_params)) {
                $this->filters = $this->addFilter($column, $value, 'user');
            } else {
                $this->filters = $this->addFilter($column, $value);
            }
            /*
             * Wait for the product_reviews to change
             *
                else if (in_array($column, $this->product_review_metric_params)) {
                    $this->filters = $this->addFilter($column, $value, 'review_metric');
                }
            */
        }
        return $this->filters;
    }
    protected function addFilter($column, $value, $relation = null)
    {
        $this->filters[] = compact(['column', 'value', 'relation']);
        return $this->filters;
    }
}
