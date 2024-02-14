<?php

namespace app\admin\model;

use think\Model;

class BaseModel extends Model
{
  protected function prefixImgUrl($value, $data) {
    if ($data['from'] == 1)
      return get_config('setting.img_prefix').$value;
    return $value;
  }
}