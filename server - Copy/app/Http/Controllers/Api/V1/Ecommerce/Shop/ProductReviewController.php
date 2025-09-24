<?php

namespace App\Http\Controllers\Api\V1\Ecommerce\Shop;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Ecommerce\ProductModel;
use Exception;
use Illuminate\Http\Request;
use Str;
use Validator;


class ProductReviewController extends Controller
{


    public function review_index()
    {
        try {
            $product_reviews_builder = ProductModel::where(['shop_id' => auth('ecommerce')->user()->shop->id]);

            if (!$product_reviews_builder->get()) {
                return $this->errorResponse("Shop hiện chưa có sản phẩm nào!");
            }

            $limit = request('limit', 20);
            $page = request('page', 1);
            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');
            if($product_reviews_builder->first()){
                $product_reviews = $product_reviews_builder
                    ->filterAndSort($product_reviews_builder->first()->getFilters(), $sort_by, $sort_direction)
                    ->with(['latest_review', 'latest_review.user', 'review_metric'])
                    ->paginate($limit, ['*'], 'page', $page);
                $product_reviews->getCollection()->transform(function ($item) {
                    $item->stars = $item->stars();
                    return $item;
                });
                return $this->successResponsePagination('Lấy danh sách reviews thành công', $product_reviews->items(), $product_reviews);
            }
            return $this->successResponse('ok',[]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }



    public function review_get($product_id)
    {
        try {
            $product = ProductModel::with('category')->where(['shop_id' => auth('ecommerce')->user()->shop->id])->findOrFail($product_id);



            $limit = request('limit', 20);
            $page = request('page', 1);
            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');

            // return 123;
            if($product->reviews->first()){
                $reviews = $product->reviews()
                    ->filterAndSort($product->reviews->first()->getFilters(), $sort_by, $sort_direction)
                    ->with(['user', 'reply.shop'])
                    ->paginate($limit, ['*'], 'page', $page);

                $reviews->getCollection()->transform(function ($review) {
                    $review->is_like = ['like_status' => $review->is_like(), 'counting' => $review->likes_count]; // Call the `is_like` method on each review
                    return $review;
                });
                return $this->successResponsePagination('Lấy danh sách reviews của sản phẩm thành công', $reviews->items(), $reviews);

            }else{
                return $this->successResponse('ok',[]);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
