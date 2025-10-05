<?php

namespace App\Models\Api\V1\Cms;

use App\Models\HmsModel;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use App\Services\FileService;


class MenuItemModel extends HmsModel
{
    use ApiResponse;
    public function __construct()
    {
        $this->table = TABLE_CMS_MENU_ITEM;
        parent::__construct();
    }

    public $crudNotAccepted = ['options','prices'];
    protected $guarded = [];
    protected $hidden = ['updated_at', 'updated_by'];
    protected $casts = [
        'features' => 'array'
    ];

    public function listItem($params = null, $options = null)
    {
        $results = null;
        if ($options['task'] == 'index') {
            $query = self::query()->where('reraurant_id', auth('cms')->user()->restaurant->id)
                ->with('category:id,name');
            // lọc theo tên
            if (!empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }
            // lọc theo trạng thái
            if (!empty($params['status'])) {
                $query->where('status', $params['status']);
            }
            $results = $query->orderBy('priority', 'asc')->orderBy('created_at', 'desc')
                ->paginate($params['limit'] ?? 20);
            return $results;
        }

    }
    public function saveItem($params = null, $options = null)
    {
        $results = null;
        if ($options['task'] == 'add-item') {

            $params['created_by'] = auth('cms')->id();
            $params['created_at'] = now();
            $params['status'] = 'active';
            $params['priority'] = $params['priority'] ?? 9999;
            $params['slug'] = Str::slug($params['name']) . '-' . Str::random(5);
            // return $params;
            // if (request()->hasFile(('image'))) {
            //     $params['image'] = FileService::file_upload($params, $params['image'], 'restaurant.menu_category');
            // }

            $item = self::create($this->prepareParams($params));
            // thêm options nếu có
            if (count($params['options'] ?? []) > 0) {
                foreach ($params['options'] as $option) {
                    $option_item = [
                        'menu_item_id' => $item->id,
                        'name' => $option['name'],
                        'type' => $option['type'],// single, multiple
                        'required' => $option['required'] ?? 0, // yes, no
                        'priority' => $option['priority'] ?? 9999,
                        'status' => $option['status'] ?? 'active',
                        'created_by' => auth('cms')->id(),
                        'created_at' => now(),
                    ];
                    $option_item = MenuOptionModel::create($option_item);
                    // thêm option values nếu có
                    if (count($option['values'] ?? []) > 0) {
                        foreach ($option['values'] as $value) {
                            $value_item = [
                                'option_id' => $option_item->id,
                                'name' => $value['name'],
                                'extra_price' => $value['extra_price'] ?? 0,
                                'created_by' => auth('cms')->id(),
                                'created_at' => now(),
                            ];
                            MenuOptionValueModel::create($value_item);
                        }
                    }
                }
                // thêm menu price nếu có
                if (count($params['prices'] ?? []) > 0) {
                    foreach ($params['prices'] as $price) {
                        $price_item = [
                            'menu_item_id' => $item->id,
                            'type' => $price['type'],
                            'price' => $price['price'],
                            'valid_from' => $price['valid_from'] ?? '',
                            'valid_to' => $price['valid_to'] ?? '',
                            'status' => $price['status'] ?? 'active',
                            'created_by' => auth('cms')->id(),
                            'created_at' => now(),
                        ];
                        MenuPriceModel::create($price_item);
                    }
                }


                return $item;
            }
            return $item;

        }
        if ($options['task'] == 'edit-item') {

            $params['updated_by'] = auth('cms')->id();
            $params['updated_at'] = now();

            $item = self::find($params['id'] ?? 0);

            if (request()->hasFile(('image'))) {
                $params['image'] = FileService::file_upload($params, $params['image'], 'restaurant.' . $params['controller']);
            }

            $item->update($this->prepareParams($params));
            // cập nhật options nếu có
            if (count($params['options'] ?? []) > 0) {
                foreach ($params['options'] as $option) {
                    if (isset($option['id']) && $option['id'] > 0) {
                        // cập nhật tuỳ chọn
                        $option_item = MenuOptionModel::find($option['id']);
                        if ($option_item) {
                            $option_item->update([
                                'name' => $option['name'],
                                'type' => $option['type'],// single, multiple
                                'required' => $option['required'] ?? 0, // yes, no
                                'priority' => $option['priority'] ?? 9999,
                                'status' => $option['status'] ?? 'active',
                                'updated_by' => auth('cms')->id(),
                                'updated_at' => now(),
                            ]);
                        }
                        // cập nhật option values nếu có
                        if (count($option['values'] ?? []) > 0) {
                            foreach ($option['values'] as $value) {
                                if (isset($value['id']) && $value['id'] > 0) {
                                    // cập nhật giá trị tuỳ chọn
                                    $value_item = MenuOptionValueModel::find($value['id']);
                                    if ($value_item) {
                                        $value_item->update([
                                            'name' => $value['name'],
                                            'extra_price' => $value['extra_price'] ?? 0,
                                            'updated_by' => auth('cms')->id(),
                                            'updated_at' => now(),
                                        ]);
                                    }
                                } else {
                                    // thêm mới giá trị tuỳ chọn
                                    $value_item = [
                                        'option_id' => $option_item->id,
                                        'name' => $value['name'],
                                        'extra_price' => $value['extra_price'] ?? 0,
                                        'created_by' => auth('cms')->id(),
                                        'created_at' => now(),
                                    ];
                                    MenuOptionValueModel::create($value_item);
                                }
                            }
                        }
                    } else {
                        // thêm mới tuỳ chọn
                        $option_item = [
                            'menu_item_id' => $item->id,
                            'name' => $option['name'],
                            'type' => $option['type'],// single, multiple                   
                            'required' => $option['required'] ?? 0, // yes, no
                            'priority' => $option['priority'] ?? 9999,
                            'status' => $option['status'] ?? 'active',
                            'created_by' => auth('cms')->id(),
                            'created_at' => now(),
                        ];
                        $option_item = MenuOptionModel::create($option_item);
                        // thêm option values nếu có
                        if (count($option['values'] ?? []) > 0) {
                            foreach ($option['values'] as $value) {
                                $value_item = [
                                    'option_id' => $option_item->id,
                                    'name' => $value['name'],
                                    'extra_price' => $value['extra_price'] ?? 0,
                                    'created_by' => auth('cms')->id(),
                                    'created_at' => now(),
                                ];
                                MenuOptionValueModel::create($value_item);
                            }
                        }
                    }
                }
                // cập nhật menu price nếu có
                if (count($params['prices'] ?? []) > 0) {
                    foreach ($params['prices'] as $price) {
                        if (isset($price['id']) && $price['id'] > 0) {
                            // cập nhật giá
                            $price_item = MenuPriceModel::find($price['id']);
                            if ($price_item) {
                                $price_item->update([
                                    'name' => $price['name'],
                                    'price' => $price['price'],
                                    'priority' => $price['priority'] ?? 9999,
                                    'status' => $price['status'] ?? 'active',
                                    'updated_by' => auth('cms')->id(),
                                    'updated_at' => now(),
                                ]);
                            }
                        } else {
                            // thêm mới giá
                            $price_item = [
                                'menu_item_id' => $item->id,
                                'name' => $price['name'],
                                'price' => $price['price'],
                                'priority' => $price['priority'] ?? 9999,
                                'status' => $price['status'] ?? 'active',
                                'created_by' => auth('cms')->id(),
                                'created_at' => now(),
                            ];
                            MenuPriceModel::create($price_item);
                        }
                    }
                }
            }   

            return $item;
        }
        if ($options['task'] == 'delete-item') {
            $item = self::find($params['id'] ?? 0);
            if ($item) {
                $item->delete();
            }
        }
        if ($options['task'] == 'toggle-status') {
            $item = self::find($params['id'] ?? 0);
            if ($item) {
                $item->status = $item->status == 'active' ? 'inactive' : 'active';
                $item->updated_by = auth('cms')->id();
                $item->updated_at = now();
                $item->save();
            }
            return $item;
        }

        return $results;

    }
    public function getItem($params = null, $options = null)
    {
        $results = null;
        if ($options['task'] == 'detail') {
            $item = self::find($params['id'] ?? 0);
            return $item;
        }

        return $results;
    }

    public function user_create()
    {
        return $this->belongsTo(UserModel::class, 'created_by', 'id');
    }
    public function user_update()
    {
        return $this->belongsTo(UserModel::class, 'updated_by', 'id');
    }
    public function category()
    {
        return $this->belongsTo(MenuCategoryModel::class, 'category_id', 'id');
    }
}
