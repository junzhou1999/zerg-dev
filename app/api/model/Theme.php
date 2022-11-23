<?php

namespace app\api\model;

class Theme extends BaseModel
{
  // 一对一模型，联系在Theme表
  public function topicImg() {
    return $this->belongsTo(Image::class, 'topic_img_id', 'id');
  }

  public function headImg() {
    return $this->belongsTo(Image::class, 'head_img_id', 'id');
  }

}