<?php

namespace app\api\model;

class ProductImage extends BaseModel
{
  protected $hidden = ['delete_time', 'product_id', 'img_id'];

  // 商品图片id跟image表的反向一对一
  public function imgUrl() {
    return $this->belongsTo(Image::class, 'img_id', 'id');
  }
}