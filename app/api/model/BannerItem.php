<?php
declare (strict_types=1);

namespace app\api\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class BannerItem extends Model
{
  protected $hidden = ['id', 'delete_time', 'update_time', 'banner_id', 'img_id'];
  /**
   * 反向一对一关联
   * @return \think\model\relation\BelongsTo
   */
  public function img() {
    return $this->belongsTo(Image::class, 'img_id', 'id');
  }
}
