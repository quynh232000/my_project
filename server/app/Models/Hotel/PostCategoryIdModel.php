<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;

class PostCategoryIdModel extends AdminModel
{
    public function __construct()
    {
        $this->table = TABLE_HOTEL_POST_CATEGORY_ID;

        parent::__construct();
    }
    public function saveItem($params = null, $options = null)
    {

        if ($options['task'] == 'add-item') { //thêm mới

            if(isset($params['category_id'])){

                $arrData = [];
                foreach ($params['category_id'] as $categoryId) {

                    $arrData[] = [
                        'post_id' => $params['id'],
                        'category_id' => $categoryId,
                    ];
                }
                self::insert($this->prepareParams($arrData));
            }
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') {

            if(isset($params['category_id'])){
                $existingCategoryIds = self::where('post_id', $params['id'])
                ->pluck('category_id')
                ->toArray();

            }
            $toDelete = array_diff($existingCategoryIds, $params['category_id']);

            $toAdd    = array_diff($params['category_id'], $existingCategoryIds);

            if (!empty($toDelete)) {
               self::where('post_id', $params[$this->primaryKey])
                    ->whereIn('category_id', $toDelete)
                    ->delete();
            }

            if (!empty($toAdd)) {
                $insertData = array_map(function ($categoryId) use ($params) {
                    return [
                        'post_id' => $params['id'],
                        'category_id' => $categoryId,
                    ];
                }, $toAdd);
                // dd($insertData);
                self::insert($this->prepareParams($insertData));
            }

            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }

    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {

            if(isset($params['id'])){
                self::whereIn('post_id', $params['id'])->delete();
            }

            return response()->json(array('success' => true, 'msg' => 'Cập nhật yêu cầu thành công!'));
        }
    }
}
