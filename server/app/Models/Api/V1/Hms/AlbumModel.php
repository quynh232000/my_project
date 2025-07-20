<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlbumModel extends HmsModel
{

    protected $guarded  = [];
    public $bucket      = 's3_hotel';
    protected $hidden   = [
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];
    // public $crudNotAccepted = ['update'];
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_ALBUMN;
        parent::__construct();
    }
    public function getItem($params = null, $options = null)
    {
        $results = null;

        if ($options['task'] == 'detail') {
        }
        if ($options['task'] == 'meta') {
        }

        return $results;
    }
    public function listItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'list-item') {
            $type                   = $params['type'] ?? '';
            $pointId                = $params['point_id'] ?? '';
            $params['prefix']       = 'hotel';
            $params['controller']   = 'hotel';
            $typeId                 = $type == 'thumbnail' ? 'hotel_id' : 'point_id';

            $image_url              = self::getImageColumn($params, [
                "'/images/'",
                $this->table . "." . $typeId,
                "'/'",
                $this->table . ".image",
            ], 'image_url');

            $item = self::select($this->table . '.id', $this->table . '.hotel_id', $this->table . '.label_id', $this->table . '.point_id', $image_url, $this->table . '.priority', 'a.name')
                // ->with('attribure:id,name')
                ->leftJoin(TABLE_HOTEL_ATTRIBUTE . ' as a', 'a.id', '=', $this->table . '.label_id')
                ->where('type', $type)
                ->where('point_id', $pointId)
                ->orderBy('priority', 'ASC')
                ->get();

            if (!empty($item)) {
                return [
                    'status'    => true,
                    'message'   => 'Thành công',
                    'data'      => $item
                ];
            }
        }
        if ($options['task'] == 'list') {

            $query = self::with('label:id,name,slug,parent_id', 'label.parents:id,name,slug')
                ->where('hotel_id', auth('hms')->user()->current_hotel_id);

            // if($params['type'] ?? false){
            //     $query->where('type',$params['type']);
            // }

            $results = $query->orderBy($params['column'] ?? 'priority', $params['direction'] ?? 'desc')->get();

            // Biến đổi và nhóm lại kết quả
            $grouped = [
                'rooms'         => [],
                'hotel'         => [],
            ];

            $results = $results->map(function ($item) use (&$grouped) {

                //  lấy point_id tương ứng mới type
                $point_id = $item->hotel_id;

                if ($item->type == 'room_type') {
                    $point_id = $item->point_id;
                    $item->room;
                }

                $item->image_url = $item->image;

                // Nhóm theo room và hotel
                if ($item->type == 'room_type' && $item->room) {

                    $roomId                                 = $item->room->id;

                    if (!isset($grouped['rooms'][$roomId])) {

                        $grouped['rooms'][$roomId]           = [
                            'room'      => $item->room,
                            'images'    => [],
                        ];
                    }
                    $grouped['rooms'][$roomId]['images'][]  = $item;
                } else {
                    $grouped['hotel'][]                     = $item;
                }
            });
            $results = $grouped;
        }

        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'add-item') {

            $params['type']         = $params['type'] ?? 'room_type';
            $hotel_id               = auth('hms')->user()->current_hotel_id;
            $hotel                  = HotelModel::select('id', 'slug')->where('id', $hotel_id)->first();

            $params['controller']   = 'hotel';
            $params['bucket']       = $this->bucket;

            $typeId                 = $params['type'] == 'room_type' ? $params['room_id'] : $hotel_id;
            $folderPath             = $params['controller'] . '/images/' . $typeId . '/';

            foreach ($params['images'] as $index => $item) {
                $extension          = $item['image']->getClientOriginalExtension();
                $imageName          = ($params['slug'] ?? $hotel->slug) . '-' . $index . '-' . time() . '.' . $extension;
                $params['image']    = $imageName;

                Storage::disk($params['bucket'])->put($folderPath . $imageName, file_get_contents($item['image']));
                $items[] = [
                    'label_id'      => $item['label_id'],
                    'priority'      => $item['priority'] ?? null,
                    'image'         => $imageName,
                    'type'          => $params['type'],
                    'hotel_id'      => $params['hotel_id'],
                    'point_id'      => $params['room_id'] ?? null,
                    'created_by'    => auth('hms')->id(),
                    'created_at'    => now(),
                ];
            }

            self::insert($this->prepareParams($items));

            if ($items) {

                $data = self::getListData($params, $typeId ?? null);

                return [
                    'status'        => true,
                    'status_code'   => 200,
                    'message'       => 'Cập nhật thành công!',
                    'data'          => $data
                ];
            } else {
                return [
                    'status'        => false,
                    'status_code'   => 200,
                    'message'       => 'Cập nhật thất bại!'
                ];
            }
        }

        if ($options['task'] == 'edit-item') {

            $params['controller']   = 'hotel';
            $params['bucket']       = $this->bucket;

            $hotel_id               = auth('hms')->user()->current_hotel_id;
            $hotel                  = HotelModel::select('id', 'slug')->where('id', $hotel_id)->first();
            $params['slug']         = $params['slug'] ?? $hotel->slug;
            $params['type']         = $params['type'] ?? 'room_type';

            $params['id']           = $params['type'] == 'room_type' ?  $params['id'] : $hotel_id;

            $folderPath             = $params['controller'] . '/images/' . $params['id'] . '/';

            foreach (($params['update'] ?? []) as $index => $item) {
                if ($item['image'] ?? false) {

                    $extension          = $item['image']->getClientOriginalExtension();
                    $imageName          = $params['slug'] . '-' . $index . '-' . time() . '.' . $extension;
                    Storage::disk($params['bucket'])->put($folderPath . $imageName, file_get_contents($item['image']));
                    $item['image']      = $imageName;
                }

                self::where('id', $index)->update($this->prepareParams($item));
            }
            if (count($params['delete_images'] ?? []) > 0) {
                $this->deleteItem($params['delete_images'], ['task' => 'delete-item']);
            }

            $data = self::getListData($params, $params['id']  ?? null);
            return [
                'status'        => true,
                'status_code'   => 200,
                'message'       => 'Cập nhật thành công!',
                'data'          => $data
            ];
        }
        return $results;
    }
    public function getListData($params, $point_id = null)
    {
        // lấy lại danh sách ảnh sau khi cập nhật

        $data           = null;

        if ($params['type'] == 'room_type') {
            if ($params['list-all'] ?? false) {
                $data   = self::listItem($params, ['task' => 'list']);
            } else {
                $data   = self::listItem([...$params, 'point_id' => $point_id], ['task' =>   'list-item'])['data'] ?? [];
            }
        } else {
            $data       = self::listItem($params, ['task' =>  'list']);
        }
        return $data;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            self::whereIn('id', $params)->delete();
        }
        if ($options['task'] == 'delete') {
            if (count($params['ids']) > 0) {
                $hotel_id = auth("hms")->user()->current_hotel_id;
                self::whereIn('id', $params['ids'])->where('hotel_id', $hotel_id)->delete();
            }
        }
    }
    public function getImageUrlAttribute()
    {
        return $this->attributes['image_url'] ?? null;
    }
    public function attribure()
    {
        return $this->hasOne(AttributeModel::class, 'id', 'label_id');
    }
    public function room()
    {
        return $this->belongsTo(RoomModel::class, 'point_id', 'id')->select('id', 'name_id', 'name');
    }
    public function label()
    {
        return $this->belongsTo(AttributeModel::class, 'label_id', 'id')->select('id', 'name', 'parent_id');
    }
}
