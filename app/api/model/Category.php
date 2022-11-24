<?php

namespace app\api\model;

class Category extends BaseModel
{
  protected $hidden = ['delete_time', 'update_time'];

  // 一对一
  public function img() {
    return $this->belongsTo(Image::class, 'topic_img_id', 'id');
  }
}