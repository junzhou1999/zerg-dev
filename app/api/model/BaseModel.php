<?php
declare (strict_types=1);

namespace app\api\model;

use think\facade\Config;
use think\Model;

/**
 * @mixin \think\Model
 */
class BaseModel extends Model
{
  protected function prefixImgUrl($value, $data) {
    if ($data['from'] == 1)
      return Config::get('setting.img_prefix') . $value;
    return $value;
  }
}
