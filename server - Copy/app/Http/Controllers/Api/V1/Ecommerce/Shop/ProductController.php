<?php

namespace App\Http\Controllers\Api\V1\Ecommerce\Shop;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Ecommerce\AttributeNameModel;
use App\Models\Api\V1\Ecommerce\BrandModel;
use App\Models\Api\V1\Ecommerce\CategoryModel;
use App\Models\Api\V1\Ecommerce\ProductAttributeModel;
use App\Models\Api\V1\Ecommerce\ProductModel;
use App\Models\Api\V1\Ecommerce\ShopModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Str;
use Validator;


class ProductController extends Controller
{

    public function product_index(Request $req)
    {
        try {

            $mr_quynh_demands =  ProductModel::getStateProducts(strtoupper(trim($req->state)));

            $filters = [
                [
                    'relation' => 'brand',
                    'column' => 'id',
                    'value' => $req->brand,
                ],
                [
                    'relation' => 'category',
                    'column' => 'id',
                    'value' => $req->category,
                ],
                [
                    'column' => 'price',
                    'value' => $req->range,
                ],
                [
                    'column' => 'name',
                    'value' => $req->name,
                ],
            ];

            $merge_filters = array_merge($mr_quynh_demands, $filters);

            $limit          = request('limit', 20);
            $page           = request('page', 1);
            $sort_by        = request('sort_by', 'name');
            $sort_direction = request('sort_direction', 'asc');

            $query = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)
                ->filterAndSort($merge_filters, $sort_by, $sort_direction)
                ->with('category:id,name', 'brand:id,name', 'shop:id,name');
            if($req->status && $req->status !=''){
                if($req->status == 'HIDDEN'){
                    $query->where('is_published', 0);
                }else{
                    $query->where('status', $req->status);
                }
            }

            $products       = $query->paginate($limit, ['*'], 'page', $page);

            return $this->successResponsePagination('Lấy danh sách products thành công', $products->items(), $products);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_get($id)
    {
        try {
            $product = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                return $this->errorResponse('Sản phẩm không tồn tại!', null, 404);
            }
            $product->stars=$product->stars();
            return $this->successResponse('Lấy thông tin sản phẩm thành công!', $product->getERData());
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_create(Request $req)
    {
        try {

            $shop_id = auth('ecommerce')->user()->shop->id;

            $validator = FacadesValidator::make($req->all(), [
                'name' => 'required|string|min:5|max:400',
                'image' => 'required',
                'origin' => 'required|string|min:2',
                'price' => 'required|numeric|min:500',
                'stock' => 'required|integer|min:1|max:1000',
                'description' => 'required|string|min:20',
                'category_id' => 'required|numeric|min:1',
                'priority' => 'numeric|min:0',
                'width' => 'required|numeric|gt:0',
                'height' => 'required|numeric|gt:0',
                'length' => 'required|numeric|gt:0',
                'weight' => 'required|numeric|gt:0',
                'percent_sale' => 'numeric',
                'attribute_value' => 'required',
            ]);

            if ($validator->fails()) {
                DB::rollBack();
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors());
            }

            if (empty($req->attribute_name) && empty($req->attribute_name_id)) {

                DB::rollBack();
                return $this->errorResponse('Vui lòng nhập tối thiểu một thuộc tính, hoặc dùng thuộc tính gợi ý.');
            }

            if (CategoryModel::find(trim($req->category_id))) {
                $category_id = trim($req->category_id);
            } else {
                DB::rollBack();
                return $this->errorResponse('Danh mục này không tồn tại. Vui lòng sử dụng danh mục khác.');
            };

            if ($req->brand_value) {
                $brand_name = trim($req->brand_value);
                $brand_slug = strtoupper(Str::slug($brand_name));
                if (BrandModel::where('code', $brand_slug)->exists()) {
                    $brand = BrandModel::where('code', $brand_slug)->first();
                } else {
                    $brand = BrandModel::create([
                        'name' => $brand_name,
                        'code' => $brand_slug
                    ]);
                };
            } else {
                if ($req->brand_id) {
                    if (BrandModel::find(trim($req->brand_id))) {
                        $brand = BrandModel::find(trim($req->brand_id));
                    } else {
                        DB::rollBack();
                        return $this->errorResponse('Thương hiệu không tồn tại. Vui lòng chọn tên thương hiệu.');
                    }
                } else {
                    DB::rollBack();
                    return $this->errorResponse('Vui lòng sử dụng brand được gợi ý hoặc tạo brand mới.');
                }
            }

            if (!$req->image) {
                DB::rollBack();
                return $this->errorResponse('Vui lòng chọn ảnh sản phẩm.');
            }

            $slug = Str::slug(trim($req->name));
            if (ProductModel::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . time();
            }
            $product = ProductModel::create(
                [
                    'name' => trim($req->name),
                    'slug' => $slug,
                    'image' => $req->image ?? '',
                    'sku' => !!trim($req->sku) ? trim($req->sku) : "",
                    'priority' => !!trim($req->priority) ? trim($req->priority) : 1,
                    'description' => trim($req->description),
                    'video' => $req->video ?? '',
                    'price' => trim($req->price),
                    'percent_sale' => !!trim($req->percent_sale) ? trim($req->percent_sale) : 0,
                    'origin' => trim($req->origin),
                    'category_id' => $category_id,
                    'brand_id' => $brand->id,
                    'stock' => trim($req->stock),
                    'shop_id' => $shop_id,
                    'is_published' => true
                ]
            );

            $product->shipping()->create([
                'width' => trim($req->width),
                'height' => trim($req->height),
                'weight' => trim($req->weight),
                'length' => trim($req->length),
            ]);

            // Product attributes

            // $attribute_variables = ['attribute_name', 'attribute_name_id', 'attribute_value', 'images'];

            // foreach ($attribute_variables as $attribute_variable) {

            //     $req->$attribute_variable = $req->$attribute_variable ? explode(',', $req->$attribute_variable[0]) : "";
            // }
            foreach ($req->attribute_value as $index => $option_value) {

                /** Resolve attribute name id */
                if ($req->attribute_name) {
                    if ($req->attribute_name[$index]) {
                        $check_code = strtoupper(Str::slug(trim($req->attribute_name[$index])));
                        $attribute_name = AttributeNameModel::where('code', $check_code)->first();


                        if (!$attribute_name) {
                            $attribute_name = AttributeNameModel::create([
                                "name" => trim($req->attribute_name[$index]),
                                "code" => $check_code,
                            ]);
                        }
                    }
                } else {
                    $attribute_name = AttributeNameModel::find($req->attribute_name_id[$index]);
                }

                if (ProductAttributeModel::where(['product_id' => $product->id, 'attribute_name_id' => $attribute_name->id])->first()) {
                    DB::rollBack();
                    return $this->errorResponse('Sản phẩm với thuộc tính này đã tồn tại. Vui lòng cập nhật sản phẩm, tạo thuộc tính mới hoặc tạo sản phẩm khác.');
                } else {
                    ProductAttributeModel::create([
                        'product_id' => $product->id,
                        'attribute_name_id' => $attribute_name->id,
                        'value' => $option_value,
                    ]);
                }
            }

            // Product images

            if ($req->images) {
                $save_images = [];
                foreach ($req->images as $image) {
                    $save_images[] = [
                        "url" => $image,
                        "product_id" => $product->id,
                    ];
                }
                $product->images()->insert($save_images);
            }

            DB::commit();
            return $this->successResponse('Tạo sản phẩm thành công.', $product->getERData());
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_update(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $product = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            $params_product = collect($product)->only(["name", "image", "sku", "description", "video", "percent_sale", "origin", "category_id", "priority", "is_published", "price"])->keys()->toArray();

            $params_shipping = collect($product->shipping)->only(['width', 'height', 'weight', 'length'])->keys()->toArray();

            /**
             * Product: slug
             */

            if (trim($req->name) && trim($req->name) != $product->name) {
                $slug = strtoupper(Str::slug(trim($req->name)));
                $product->slug = (bool) ProductModel::where('slug', $slug)->first() ? $slug . '-' . time() : $slug;
            }
            /**
             * Product: brand
             */

            if ($req->brand_value) {
                if (trim($req->brand_value) != $product->brand->name) {

                    $brand_name = trim($req->brand_value);
                    $brand_slug = strtoupper(Str::slug($brand_name));
                    if (BrandModel::where('code', $brand_slug)->first()) {

                        $brand = BrandModel::where('code', $brand_slug)->first();
                    } else {
                        $brand = BrandModel::firstOrCreate([
                            'code' => $brand_slug,
                            'name' => $brand_name,
                        ]);
                    }
                    $product->brand()->associate($brand);
                }
            } else {
                if ($req->brand_id) {
                    if (BrandModel::find(trim($req->brand_id))) {
                        if ($product->brand_id != trim($req->brand_id)) {
                            $brand = BrandModel::find($req->brand_id);

                            $product->brand()->associate($brand);
                        }
                    } else {
                        DB::rollBack();
                        return $this->errorResponse('Thương hiệu không tồn tại. Vui lòng chọn tên thương hiệu.');
                    }
                } else {
                    DB::rollBack();
                    return $this->errorResponse('Vui lòng sử dụng brand được gợi ý hoặc tạo brand mới.');
                }
            }

            $product->fill($req->only($params_product));

            if ($product->isDirty()) {
                $product->save();
            }

            /**
             * Product: shipping
             */

            $product->shipping->fill($req->only($params_shipping));
            // return 123;
            if ($product->shipping->isDirty()) {
                $product->shipping->save();
            }

            /**
             * Product: attributes
             */

            // $attribute_variables = ['attribute_name', 'attribute_name_id', 'attribute_value'];

            // foreach ($attribute_variables as $attribute_variable) {

            //     $req->$attribute_variable = $req->$attribute_variable ? explode(',', $req->$attribute_variable[0]) : "";
            // }
            if ($req->attribute_value) {
                foreach ($req->attribute_value as $index => $option_value) {
                    $attribute_name = null;
                    if (isset($req->attribute_name[$index])) {

                        $check_code = strtoupper(Str::slug(trim($req->attribute_name[$index])));

                        $attribute_name = AttributeNameModel::firstOrCreate(['code' => $check_code], ["name" => trim($req->attribute_name[$index])]);
                    } else {
                        $attribute_name = AttributeNameModel::find($req->attribute_name_id[$index]);
                    }

                    $product_attribute = ProductAttribute::firstOrNew([
                        'product_id' => $product->id,
                        'attribute_name_id' => $attribute_name->id,
                    ]);
                    $product_attribute->value = $option_value;

                    $product_attribute->save();
                }
            }

            /**
             * Product: images
             */

            if ($req->images) {
                $req->images = $req->images ? explode(',', $req->images[0]) : "";
                foreach ($req->images as $image) {
                    $save_images = [
                        "url" => $image,
                        "product_id" => $product->id,
                    ];
                    $product->images()->firstOrCreate($save_images);
                }
            }

            DB::commit();
            return $this->successResponse('Cập nhật sản phẩm thành công.', $product->getERData());
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function product_update_info(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $shop_id = auth('ecommerce')->user()->shop->id;
            $product = ProductModel::where('shop_id', $shop_id)->find($id);

            if (!$product) {
                DB::rollBack();
                return $this->errorResponse('Sản phẩm không tồn tại');
            }

            $validator = Validator::make($req->all(), [
                'name' => 'string|min:5|max:400',
                'origin' => 'string|min:2',
                'price' => 'numeric|min:500',
                'percent_sale' => 'numeric',
                'description' => 'string|min:20',
            ]);
            /**
             * Check for the required product attributes
             */
            if ($validator->fails()) {
                DB::rollBack();
                return $this->errorResponse(false, $validator->errors());
            }

            /**
             * product: name + slug
             */
            if (in_array(trim($req->name), ProductModel::where([['shop_id', '=', $shop_id], ['id', '<>', $id]])->pluck('name')->toArray())) {
                DB::rollBack();
                return $this->errorResponse('Sản phẩm với tên này đã tồn tại. Vui lòng sử dụng tên khác.');
            };

            if ($req->name && trim($req->name) != $product->name) {
                $product->name = trim($req->name);

                $slug = Str::slug($product->name);

                if (ProductModel::where('slug', $slug)->exists()) {
                    $slug = $slug . '-' . time();
                }
                $product->slug = strtoupper($slug);
            }

            /**
             * product: brand
             */

            if ($req->brand_value) {
                if (trim($req->brand_value) != $product->brand->name) {

                    $brand_name = trim($req->brand_value);
                    $brand_slug = strtoupper(Str::slug($brand_name));
                    if (BrandModel::where('code', $brand_slug)->first()) {

                        $brand = BrandModel::where('code', $brand_slug)->first();
                    } else {
                        $brand = BrandModel::firstOrCreate([
                            'code' => $brand_slug,
                            'name' => $brand_name,
                        ]);
                    }
                    $product->brand()->associate($brand);
                }
            } else {
                if ($req->brand_id) {
                    if (BrandModel::find(trim($req->brand_id))) {
                        if ($product->brand_id != trim($req->brand_id)) {
                            $brand = BrandModel::find($req->brand_id);

                            $product->brand()->associate($brand);
                        }
                    } else {
                        DB::rollBack();
                        return $this->errorResponse('Thương hiệu không tồn tại. Vui lòng chọn tên thương hiệu.');
                    }
                } else {
                    DB::rollBack();
                    return $this->errorResponse('Vui lòng sử dụng brand được gợi ý hoặc tạo brand mới.');
                }
            }

            /**
             * product: description, price, percent_sale, origin
             */
            $product_attrs = [
                'sku',
                'description',
                'percent_sale',
                'origin',
            ];

            foreach ($product_attrs as $attr) {
                if ($req->$attr && trim($req->$attr) != $product->$attr) {
                    $product->$attr = trim($req->$attr);
                }
            }

            $product->updated_at = Carbon::now();

            $product->save();

            DB::commit();
            return $this->successResponse('Cập nhật thông tin sản phẩm thành công.', $product);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_update_cate(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $product = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                DB::rollBack();
                return $this->errorResponse('Sản phẩm không tồn tại');
            }

            $validator = Validator::make($req->all(), [
                'category_id' => 'numeric|min:1',

            ]);

            /**
             * Check for the required product attributes
             */
            if ($validator->fails()) {
                DB::rollBack();
                return $this->errorResponse(false, $validator->errors());
            }

            /**
             * product: category
             */
            $category = CategoryModel::find(trim($req->category_id));

            if ($category) {
                if ($product->category_id != $category->id) {
                    $product->category()->associate($category);
                }
            } else {
                DB::rollBack();
                return $this->errorResponse('Danh mục này không tồn tại. Vui lòng sử dụng danh mục khác.');
            };

            $product->updated_at = Carbon::now();

            $product->save();

            DB::commit();
            return $this->successResponse('Cập nhật danh mục sản phẩm thành công.', $product);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_update_stock(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $shop_id = ShopModel::where(['user_id' => auth('ecommerce')->id()])->first()->id;

            $product = ProductModel::where('shop_id', $shop_id)->find($id);

            if (!$product) {
                DB::rollBack();
                return $this->errorResponse('Sản phẩm không tồn tại');
            }

            $validator = Validator::make($req->all(), [
                'inventory_adjustment' => 'required',
                'change_type' => 'required',
                'reason' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors());
            }

            $inventory_adjustment = (strtoupper(trim($req->change_type)) == 'REDUCE') ? -abs($req->inventory_adjustment) : abs($req->inventory_adjustment);

            if (($product->inventoryLogs()->sum('inventory_adjustment') + $inventory_adjustment) < 0) {
                DB::rollBack();
                return $this->errorResponse("Kho không đủ số lượng hàng, vui lòng rút ít hàng hóa hơn.");
            };

            $inventoryLog = $product->inventoryLogs()->create([
                'change_type' => $req->change_type ?? 'ADD',
                'inventory_adjustment' => $inventory_adjustment,
                'reason' => $req->reason ?? null,
                'shop_id' => $shop_id,
            ]);

            $product->updated_at = Carbon::now();

            $product->save();

            DB::commit();

            return $this->successResponse('Cập nhật kho và số lượng sản phẩm thành công.', $product);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function product_update_warehouse(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $product = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                DB::rollBack();
                return $this->errorResponse('Sản phẩm không tồn tại');
            }

            $validator = Validator::make($req->all(), [

                'stock' => 'integer|min:1|max:1000',
                'priority' => 'numeric|min:0',
            ]);

            /**
             * Check for the required product attributes
             */
            if ($validator->fails()) {
                DB::rollBack();
                return $this->errorResponse(false, $validator->errors());
            }

            /**
             * product: stock, priority, sku
             */
            $parameters = ['priority', 'sku',];

            foreach ($parameters as $param) {
                if ($req->$param && trim($req->$param) != $product->$param) {
                    $product->$param = trim($req->$param);
                }
            }
            $product->updated_at = Carbon::now();
            $product->save();

            DB::commit();
            return $this->successResponse('Cập nhật thông số sản phẩm thành công.', $product);
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_update_shipping(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $product = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                DB::rollBack();
                return $this->errorResponse('Sản phẩm không tồn tại');
            }

            $dimensions = ['width', 'height', 'weight', 'length',];

            $dimensions_validate = collect($dimensions)->mapWithKeys(function ($e) {
                return [$e => 'numeric|gt:0'];
            })->toArray();

            $dimensions_req =  $req->only($dimensions);

            $dimensions_pro = $product->shipping->only($dimensions);

            $validator = Validator::make($req->all(), $dimensions_validate);


            /**
             * Check for the required product attributes
             */
            if ($validator->fails()) {
                DB::rollBack();
                return $this->errorResponse(false, $validator->errors());
            }

            /**
             * product_shipping
             */

            $product->shipping()->update(array_diff_assoc($dimensions_req, $dimensions_pro));

            $product->updated_at = Carbon::now();
            $product->shipping->save();

            DB::commit();
            return $this->successResponse('Cập nhật sản phẩm thành công.', $product->load('shipping'));
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_update_media(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $product = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                DB::rollBack();
                return $this->errorResponse('Sản phẩm không tồn tại');
            }


            /**
             * Product: image + video
             */
            $params_product = collect($product)->only(["image", "video"])->keys()->toArray();

            $product->fill($req->only($params_product));

            if ($product->isDirty()) {
                $product->save();
            }

            /**
             * Product: images
             */

            if ($req->images) {
                $req->images = $req->images ? explode(',', $req->images[0]) : "";
                foreach ($req->images as $image) {
                    $save_images = [
                        "url" => $image,
                        "product_id" => $product->id,
                    ];
                    $product->images()->firstOrCreate($save_images);
                }
            }

            DB::commit();
            return $this->successResponse('Cập nhật sản phẩm thành công.', $product->load('images')->only(['image', 'video', 'images']));
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_update_attribute_by_id(request $req, $id, $attribute_id)
    {
        DB::beginTransaction();
        try {
            $product = productModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                return $this->errorresponse('sản phẩm không tồn tại');
            }

            $validator = validator::make($req->all(), []);

            /**
             * check for the required product attributes
             */
            if ($validator->fails()) {
                return $this->errorresponse(false, $validator->errors());
            }

            if (empty($req->attribute_name) && empty($req->attribute_name_id)) {
                return $this->errorresponse('vui lòng nhập tối thiểu một thuộc tính, hoặc dùng thuộc tính gợi ý.');
            }

            $product_attribute = $product->attributes->find($attribute_id);

            if ($product_attribute) {
                if ($req->attribute_name) {
                    $check_code = strtoupper(str::slug(trim($req->attribute_name)));

                    $attribute_name = attributenameModel::where('code', $check_code)->first();

                    if (!$attribute_name) {
                        $attribute_name = attributenameModel::create([
                            "name" => trim($req->attribute_name),
                            "code" => $check_code,
                        ]);
                    }
                } else {
                    $attribute_name = AttributeNameModel::find($req->attribute_name_id);
                    if (!$attribute_name) {
                        return $this->errorresponse('Thuộc tính với mã này không tồn tại. vui lòng sử dụng thuộc tính có sẵn hoặc, tạo thuộc tính mới.');
                    }
                }

                if ($attribute_name->id != $product_attribute->attribute_name_id) {
                    $product_attribute->attribute_name_id = $attribute_name->id;
                }

                if ($req->attribute_value) {

                    if (trim($req->attribute_value) != $product_attribute->value) {
                        $product_attribute->value = trim($req->attribute_value);
                    }
                }

                $product_attribute->updated_at = carbon::now();

                $product_attribute->save();

                DB::commit();
            } else {
                return $this->errorresponse('Sản phẩm với thuộc tính này không tồn tại. Vui lòng sử dụng thuộc tính có sẵn hoặc, tạo thuộc tính mới.');
            }

            return $this->successresponse('Cập nhật thuộc tính sản phẩm thành công.', $product->load('attributes', 'attributes.attribute_name',)->only(['id', 'attributes']));
        } catch (\Exception $e) {

            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_delete($id)
    {
        DB::beginTransaction();
        try {
            $product = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                DB::rollBack();
                return $this->errorResponse('Product không tồn tại');
            }

            if ($product['used_quantity'] != 0) {
                DB::rollBack();
                return $this->errorResponse('Product đã được sử dụng, vui lòng không xoá.');
            }

            $product->delete();

            DB::commit();
            return $this->successResponse('Xóa sản phẩm thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_restore($id)
    {
        DB::beginTransaction();
        try {
            $product_deleted = ProductModel::withTrashed()->where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product_deleted) {
                DB::rollBack();
                return $this->errorResponse('Sản phẩm không tồn tại trong thùng rác.');
            } else if (ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id)) {
                DB::rollBack();
                return $this->errorResponse('Không thể khôi phục sản phẩm đang hoạt động.');
            }

            $product_deleted->restore();

            $product = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            DB::commit();
            return $this->successResponse('Khôi phục sản phẩm thành công.', $product->getERData());
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_clone($id)
    {
        DB::beginTransaction();
        try {
            $product = ProductModel::where(['shop_id' => auth('ecommerce')->user()->shop->id])->find($id);

            if (!$product->first()) {
                DB::rollBack();
                return $this->errorResponse('Product không tồn tại');
            }
            /**
             * Clone product but not updated product_id in nested eloquent relations yet.
             */

            $product_clone = $product->getReplicate();

            $product_clone->slug = strtoupper(Str::slug($product_clone->name . '-' . time()));

            $product_clone->sold = 0;
            $product_clone->view_count = 0;
            $product_clone->is_published = 1;
            $product_clone->status = 'PENDING';

            $product_clone->save();

            /**
             * Update product_id in ER's children: images + attributes
             */

            $nested_relations = ['images', 'attributes'];

            foreach ($nested_relations as $relation) {
                if ($product->$relation()->exists()) {
                    $clone_items = $product->$relation->map(function ($item) use ($product_clone) {
                        $clone_item = $item->replicate();
                        $clone_item->product_id = $product_clone->id;
                        return $clone_item;
                    });

                    $product_clone->$relation()->saveMany($clone_items);
                    $product_clone->load($relation);
                }
            }

            /**
             * Update product_id in ER directly: shipping
             */

            if ($product->shipping) {
                $clone_shipping = $product->shipping->replicate();
                $clone_shipping->product_id = $product_clone->id;
                $product_clone->shipping()->save($clone_shipping);
                $product_clone->load('shipping');
            }

            DB::commit();
            return $this->successResponse('Sao chép sản phẩm thành công.', $product_clone->load('inventoryLogs', 'priceLogs'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }


    public function product_update_visibility($id)
    {
        DB::beginTransaction();
        try {

            $product = ProductModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                DB::rollBack();
                return $this->errorResponse('Sản phẩm không tồn tại');
            }

            $product->is_published = $product->is_published == 0 ? 1 : 0;
            $product->save();

            DB::commit();
            return $this->successResponse('Cập nhật sản phẩm thành công.', $product->only(['id', 'is_published']));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_delete_attribute_by_id(request $req, $id, $attribute_id)
    {
        DB::beginTransaction();
        try {
            $product = productModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                return $this->errorresponse('sản phẩm không tồn tại');
            }

            $product_attribute = $product->attributes->find($attribute_id);

            if ($product_attribute) {
                $product_attribute->delete();
                db::commit();
                return $this->successresponse('Xóa thuộc tính sản phẩm thành công.', $product->load('attributes')->only(['id', 'attributes']));
            } else {
                DB::rollBack();
                return $this->errorresponse('sản phẩm không tồn tại thuộc tính này. vui lòng thử lại', $product->load('attributes')->only(['id', 'attributes']));
            }
        } catch (\Exception $e) {

            DB::rollBack();
            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function product_delete_image_by_id($id, $image_id)
    {
        DB::beginTransaction();
        try {

            $product = productModel::where('shop_id', auth('ecommerce')->user()->shop->id)->find($id);

            if (!$product) {
                return $this->errorresponse('sản phẩm không tồn tại');
            }

            $product_image = $product->images->find($image_id);


            if ($product_image) {
                $product_image->delete();
                db::commit();
                return $this->successresponse('Xóa ảnh sản phẩm thành công.', $product->load('images')->only(['id', 'images']));
            } else {
                DB::rollBack();
                return $this->errorresponse('sản phẩm không tồn tại ảnh này. vui lòng thử lại', $product->load('images')->only(['id', 'images']));
            }
        } catch (\Exception $e) {

            DB::rollBack();
            report($e);
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
