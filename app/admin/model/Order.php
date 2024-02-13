<?php

namespace app\admin\model;

class Order extends BaseModel
{
  /**
   * @param $page
   * @param $size
   * @param $sort create_time字段的排序，默认：DESC
   * @return \think\Paginator
   * @throws \think\db\exception\DbException
   */
  public static function getSummaryByPage($page=1, $size=20, $orderStr){

    // 当前页数，每一页数目
    $pagingData = self::order($orderStr)->paginate(['page' => $page, 'list_rows' => $size], false);

    return $pagingData ;
  }
}