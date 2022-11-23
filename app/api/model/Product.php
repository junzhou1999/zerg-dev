<?php

namespace app\api\model;

class Product extends BaseModel
{
  // pivot：多对多产生的中间表、数据
  protected $hidden = [
    'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
    'create_time', 'update_time'];

  public function getMainImgUrlAttr($value, $data) {
    return $this->prefixImgUrl($value, $data);
  }
}