<?php

namespace App\Imports;

use App\Models\AttributeName;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Str;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        try {
            foreach ($collection->toArray() as $row) {
                $this->addProduct($row);
            }
            return 'Import success';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function addProduct($data)
    {
        $brand_name = trim($data['thuong_hieu']);
        $brand_slug = strtoupper(Str::slug($brand_name));
        if (Brand::where('code', $brand_slug)->exists()) {
            $brand = Brand::where('code', $brand_slug)->first();
        } else {
            $brand = Brand::create([
                'name' => $brand_name,
                'code' => $brand_slug
            ]);
        }

        // check slug
        $slug = Str::slug(trim($data['ten']));
        if (Product::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }
        // dd($data);
        // add new product
        $product = Product::create(
            [
                'name'          => $data['ten'],
                'slug'          => $slug,
                'image'         => $data['anh_chinh'] ?? '',
                'sku'           => $data['sku'],
                'priority'      => $data['thu_tu'] ?? 1,
                'description'   => $data['mo_ta'],
                'video'         => $data['video'] ?$data['video'].'?q-type=.mp4' : '',
                'price'         => $data['gia_ban'],
                'percent_sale'  => $data['khuyen_mai'] ?? 0,
                'origin'        => $data['xuat_su'] ?? '',
                'category_id'   => $data['danh_muc'] ?? 1,
                'brand_id'      => $brand->id ?? 1,
                'stock'         => $data['so_luong'] ?? 1,
                'shop_id' => auth('ecommerce')->user()->shop->id,
                // 'shop_id'       => 2,
                'is_published'  => true
            ]
        );

        // shipping
        $product->shipping()->create([
            'width'  => ($data['chieu_rong']),
            'height' => ($data['chieu_cao']),
            'weight' => ($data['can_nang']),
            'length' => ($data['chieu_dai']),
        ]);

        // them thuoc tinh
        $arrAttributes = explode(',', $data['thuoc_tinh_gia_tri']);
        foreach ($arrAttributes as $item) {
            $name  = explode('|', $item)[0];
            $value = explode('|', $item)[1];
            $name_slug = Str::slug($name);
            $checkAttr = AttributeName::where('code', $name_slug)->first();
            if (!$checkAttr) {
                $checkAttr = AttributeName::create([
                    'name' => $name,
                    'code' => $name_slug,
                ]);
            }
            ProductAttribute::create([
                'product_id'        => $product->id,
                'attribute_name_id' => $checkAttr->id,
                'value'             => $value,
            ]);

        }
        // image
        $arrimages = explode('|',$data['anh_phu']);
        foreach ($arrimages as $item) {
            ProductImage::create([
                'product_id'=>$product->id,
                'url'=>$item
            ]);
        }

    }
}
