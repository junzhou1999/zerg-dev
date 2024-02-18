<?php

namespace app\admin\model;

class Category extends BaseModel
{
  protected $hidden = ['delete_time', 'update_time'];

  // 一对一
  public function img() {
    return $this->belongsTo(Image::class, 'topic_img_id', 'id');
  }

  public static function getCatByPage($page=1, $size=10){
    $pagingData = self::with(['img' => function($query){
          $query->visible(['url']);}])
        ->paginate(['page' => $page, 'list_rows' => $size]);

    return $pagingData;
  }
}