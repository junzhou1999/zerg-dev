<?php
declare (strict_types=1);

namespace app\api\model;

/**
 * @mixin \think\Model
 */
class Image extends BaseModel
{
  protected $hidden = ['id', 'delete_time', 'update_time', 'from'];

  /**
   * 获取器
   * @param $value
   * @param $data  查询到的字段值都传过来了
   * @return string
   */
  public function getUrlAttr($value, $data) {
    return $this->prefixImgUrl($value, $data);
  }
}
