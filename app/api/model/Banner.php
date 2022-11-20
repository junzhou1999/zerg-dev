<?php

namespace app\api\model;

use think\facade\Db;

class Banner
{
  /**
   * modal获取数据库元组信息
   * @param $id
   * @return
   */
  public static function getBannerByID($id) {
    $res = Db::query('select * from banner_item where banner_id = ?', [$id]);
    return $res;
  }
}