<?php

namespace app\admin\model;

class Product extends BaseModel
{
  protected $hidden = ['delete_time', 'main_img_id','from', 'category_id'];

  public static function getAllByPage($page=1, $size=10, $orderStr){
    $pagingData = self::with(['category' => function ($query){
      $query->visible(['name']);
        }])
        ->order($orderStr)
        ->paginate(['page' => $page, 'list_rows' => $size]);

    return $pagingData;
  }

  public function getMainImgUrlAttr($value, $data) {
    return $this->prefixImgUrl($value, $data);
  }

  public function category() {
    return $this->belongsTo(Category::class,'category_id', 'id');
  }
}