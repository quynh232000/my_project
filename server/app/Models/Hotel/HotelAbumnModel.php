<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Kalnoy\Nestedset\NodeTrait;
use Str;

class HotelAbumnModel extends AdminModel
{
    use NodeTrait;
    protected $bucket  = 's3_hotel';
    protected $guarded = ['id'];
    public function __construct($attributes = [])
    {

        $this->table = TABLE_HOTEL_ALBUMN;
        $this->attributes = $attributes;
        parent::__construct();
    }
    public function getItem($params = null, $options = null){

        $result = null;

        if ($options['task'] == 'get-by-hotel') {
            $result = self::select('name','slug')->where('hotel_id',$params['id'])->groupBy('slug','name')->get();
        }
        if ($options['task'] == 'get-img') {
            $img = self::select('image')->where('slug',$params['slug'])->where('hotel_id',$params['id'])->get();
            $result = $img->map(function ($item) use($params) {
                $params['controller']       = 'hotel';
                $params['item']['id']       = $params['id'];
                $params['item']['content']  = $params['id'];
                $item->image =  $this->getImageUrlS3($item->image, $params);

                return $item;
            })->toArray();
        }
        if ($options['task'] == 'get-room-image') {
            $roomImage              = self::where(['point_id' => $params['item']['id'], 'type' => 'room_type'])->get();
            $params['controller']   = $params['prefix'];
            $params['item']['id']   = $params['item']['hotel_id'];
            $result                 = $roomImage->map(function ($item) use ($params) {
            $item->image            = $this->getImageUrlS3($item->image, $params);
                return $item;
           })->toArray();
        }
        return $result;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
            $arrData                = [];
            foreach ($params as $key => $abumn) {
                $arrayExplode   = explode('|', $key) ?? null;
                $point_id       = null;
                $type           = $key;
                if($arrayExplode){
                    $point_id   = $arrayExplode[1] ?? null;
                    $type       = $arrayExplode[0] ?? 'other';
                }
                foreach (($abumn ?? []) as $k => $image) {
                    $extension          = $image->getClientOriginalExtension();
                    $imageName          = $options['slug'] . '-' . $k . '-' . time() . '.' . $extension;
                    Storage::disk($this->bucket)->put($options['folderPath'] . $imageName, file_get_contents($image));
                    $arrData[]          = [
                                            'hotel_id'     => $options['insert_id'],
                                            'image'        => $imageName,
                                            'label_id'     => $options['image_name'][$key][$k] ?? '',
                                            'point_id'     => $point_id,
                                            'type'         => $type,
                                            'created_by'   => Auth::user()->id,
                                            'created_at'   => date('Y-m-d H:i:s'),
                                        ];
                }
            }
            if(count($arrData) > 0){
                self::insert($this->prepareParams($arrData));
            }
            return true;
        }
        if ($options['task'] == 'add-room-img') {
            $params['controller']   = $params['prefix'];
            $folderPath             = $params['controller'] . '/images/' . $params['hotel_id'] . '/';
            $images                 = $params['images']['image'];
            $params['bucket']       = 's3_' . $params['prefix'];
            $params['inserted_id']  = $params['hotel_id'];
            foreach ($params['images']['image'] as $index => $nameImage) {
                $extension          = $images[$index]->getClientOriginalExtension();
                $imageName          = $params['slug'] . '-' . $index . '-' . time() . '.' . $extension;
                $params['image']    = $imageName;

                Storage::disk( $params['bucket'])->put($folderPath . $imageName, file_get_contents($images[$index]));
                $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
                $result[] = [
                    'label_id'      => $params['images']['name'][$index],
                    'image'         => $imageName,
                    'type'          => 'room_type',
                    'hotel_id'      => $params['hotel_id'],
                    'point_id'      => $params['room_type_id'],
                ];
            }
            self::insert($this->prepareParams($result));
        }
        if ($options['task'] == 'edit-room-img') {
            $list_old_image   = json_decode($params['list_image']);
            foreach($list_old_image as $key => $id_img){
                $this->where($this->primaryKey, $id_img)
                    ->update(
                    [$this->table . '.slug' => $params['images']['name'][$key]]);
            }
            if (request()->hasFile('images.image')) {
                $indexImage             = count($list_old_image);
                $params['controller']   = $params['prefix'];
                $folderPath             = $params['prefix'] . '/images/' . $params['hotel_id'] . '/';
                $images                 = $params['images']['image'];
                $params['bucket']       = 's3_' . $params['prefix'];
                $params['inserted_id']  = $params['hotel_id'];
                foreach ($params['images']['image'] as $index => $nameImage) {
                    $extension          = $images[$index]->getClientOriginalExtension();
                    $imageName          = $params['slug'] . '-' . $index . '-' . time() . '.' . $extension;
                    $params['image']    = $imageName;
                    Storage::disk( $params['bucket'])->put($folderPath . $imageName, file_get_contents($images[$index]));
                    $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
                    $result[] = [
                        'label_id'      => $params['images']['name'][$indexImage],
                        'image'         => $imageName,
                        'type'          => 'room_type',
                        'hotel_id'      => $params['hotel_id'],
                        'point_id'      => $params['room_type_id'],
                    ];
                    $indexImage++;
                }
                self::insert($this->prepareParams($result));
            }
        }
        if ($options['task'] == 'edit-item') {
            $dataOld = $params['old'] ?? [];
            $dataNew = $params['new'] ?? [];

            foreach ($dataNew as $key => $value) {
                if($value != ($dataOld[$key] ?? null)){//nếu lựa chọn bị thay đổi thì cập nhật ảnh thuộc lựa chọn cũ đó
                    $arrOldExplode  = explode('|', $dataOld[$key]);
                    $arrExplode     = explode('|', $value);

                    $point_id       = $arrExplode[1] ?? null;

                    $query          = self::where(['hotel_id' => $options['insert_id']]);

                    $query->where('type',$arrOldExplode[0]);
                    if($arrOldExplode[0] == 'service' || $arrOldExplode[0] == 'room_type'){
                        $query->where('point_id',$arrOldExplode[1]);
                    }
                    $query->update([
                        'point_id'        => $point_id,
                        'type'            => $arrExplode[0] ?? 'other',
                        'updated_by'      => Auth::user()->id,
                        'updated_at'      => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            return true;
        }
        if ($options['task'] == 'update-name-image'){
            foreach (($params ?? []) as $key => $value) {
                self::where('id',$key)
                    ->update([
                        'label_id'         => $value,
                    ]);
            }
        }
    }
    public function listItem($params = null, $options = null){
        $result = null;
        if ($options['task'] == 'list-by-hotel') {
            $params['item']['content'] = '';
             $data   = self::where('hotel_id',$params['item']['id'])->get();
             $result = $data->map(function ($item) use($params) {
                $item->image =  $this->getImageUrlS3($item->image, $params);
                return $item;
             })->toArray();
        }
        if ($options['task'] == 'list-abumn') {
            $result = self::where('hotel_id',$params['id'])
                            ->select('point_id','type')
                            ->groupBy('type','point_id')
                            ->orderBy('created_at','asc')
                            ->get()
                            ->map(function ($item)  {
                                switch ($item->type) {
                                    case 'service':
                                        $item->album_name   = ServiceModel::find($item->point_id)->name ?? ''; // get name service from service_id.
                                        break;
                                    case 'room_type':
                                        $item->album_name   = RoomTypeModel::find($item->point_id)->name ?? ''; // get name room type from room_type_id
                                        break;
                                    case 'thumbnail':
                                        $item->album_name   = 'Ảnh bìa';
                                        break;
                                    default:
                                    $item->album_name       = 'Khác';
                                        break;
                                }
                                return $item;
                            })->toArray();
        }
        if ($options['task'] == 'room-image') {
            $result    = self::where(['point_id' => $params['id'], 'type' => 'room_type'])->get()->pluck('id')->toArray();
        }
        return $result;
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item'){
            if(count($params['image'] ?? []) > 0){
                self::where('hotel_id',$options['insert_id'])->whereNotIn('id',$params['image'])->delete();
            }else{
                self::where('hotel_id',$options['insert_id'])->delete();
            }
        }
        if ($options['task'] == 'delete-room-img') {
            if($params){
                self::whereIn('id',$params)->delete();
            }
            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }
    }
    public function service() {
        return $this->belongsTo(ServiceModel::class,'point_id','id');
    }
}
