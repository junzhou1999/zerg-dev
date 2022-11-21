<?php

namespace app\api\model;

use think\facade\Db;
use think\Model;

class Banner extends Model
{
  /**
   * modal获取数据库元组信息
   * @param $id
   * @return
   */
  public static function getBannerByID($id) {
    // 原生sql查询
    // $res = Db::query('select * from banner_item where banner_id = ?', [$id]);

    // 链式查询
//    $res = Db::table('banner_item')
//      ->where(function ($query) use ($id) {   // where(可以用表达式，也可以用闭包的方式)
//        $query->where('banner_id', '=', $id);
//      })
//      ->select();

    // 链式查询
    $res = Db::table('banner_item')
      ->where('banner_id', '=', $id)  // 返回Query对象，不会立即查询数据库
      ->select();

    return $res;
  }
}