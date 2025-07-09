<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class ReviewImageModel extends AdminModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_REVIEW_IMAGE;

        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'list-review-image') {
           $imageReview    = self::where('hotel_review_id',$params['id'])->get();
           $result = $imageReview->map(function ($item) use ($params) {
                    $item->image =  $this->getImageUrlS3($item->image, $params);
                    return $item;
           })->toArray();
        }
        if ($options['task'] == 'list-image') {
            $result    = self::where('hotel_review_id',$params['id'])->get()->pluck('id')->toArray();
        }
        return $result;
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {
            $folderPath             = $params['controller'] . '/images/' . $params['inserted_id'] . '/';
            foreach ($params['images']['review'] as  $key => $image) {
                $extension          = $image->getClientOriginalExtension();
                $imageName          = $params['hotel_slug']['slug'] . '-' . $key . '-' . time() . '.' . $extension;
                $params['image']    = $imageName;
                Storage::disk($params['bucket'])->put($folderPath . $imageName, file_get_contents($image));
                $this->reSizeImageThumb($params, ['task' => 'add-item-id']);
                $result[] = [
                    'image'              => $imageName,
                    'hotel_review_id'    => $params['inserted_id'],
                ];
            }
            self::insert($this->prepareParams($result));
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
    }
    public function getImageUrlS3($fileName, $params)
    {
        $filePath = $params['controller'] .'/images/'. $params['id'] .'/'. $fileName;
        return Storage::disk('s3_'.$params['prefix'])->url($params['prefix'] .'/'. $filePath);
    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {

            foreach ($params['imageDiff'] as $imageId) {
                $image      = self::find($imageId);
                $folderPath = $params['controller'] . '/images/' . $image->hotel_review_id . '/';
                Storage::disk($params['bucket'])->delete($folderPath . $image->image);
                Storage::disk($params['bucket'])->delete($folderPath . 'thumb1/' . $image->image);
                self::where('id', $imageId)->delete();
            }
        }
    }
}
