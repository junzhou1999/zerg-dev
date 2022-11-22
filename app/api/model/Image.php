<?php
declare (strict_types=1);

namespace app\api\model;

use think\facade\Config;
use think\Model;

/**
 * @mixin \think\Model
 */
class Image extends Model
{
  protected $visible = ['url'];

  /**
   * 获取器
   * @param $value
   * @param $data  查询到的字段值都传过来了
   * @return string
   */
  public function getUrlAttr($value, $data) {
    if ($data['from'] == 1)
      return Config::get('setting.img_prefix') . $value;
    return $value;

  }
}
