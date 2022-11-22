<?php

namespace app\api\model;

//use app\api\model\Banner as BannerModel;
use think\Model;

class Banner extends Model
{
  // 不显示字段给客户端
  protected $hidden = ['delete_time', 'update_time'];

  /**
   * 1对*关联模型
   * @return void
   */
  public function items() {
    return $this->hasMany(BannerItem::class, 'banner_id', 'id');
  }

  /**
   * modal获取数据库元组信息
   * @param $id
   * @return
   */
  public static function getBannerByID($id) {
    $banner = self::with(['items', 'items.img'])->find($id);  // 直接使用模型来查询

    return $banner;
  }
}