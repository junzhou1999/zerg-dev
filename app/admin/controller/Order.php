<?php

namespace app\admin\controller;

use app\admin\business\Result;
use app\admin\validate\PagingParameter;
use app\admin\model\Order as OrderModel;

class Order
{
  /**
   * 获取全部订单简要信息（分页）
   * @param int $page
   * @param int $size
   * @return array
   * @throws \app\lib\exception\ParameterException
   */
  public function getSummary($page=1, $size = 20, $sort_create_time = '', $sort_status = ''){
    // 验证
    (new PagingParameter())->goCheck();

    // order排序跟分页查询
    $orderStr = 'create_time DESC,status ASC';
    // 两个排序有可能只传来一个
    if(empty($sort_create_time))  $orderStr='status '.$sort_status;
    if(empty($sort_status))  $orderStr='create_time '.$sort_create_time;

    $pagingOrders = OrderModel::getSummaryByPage($page, $size, $orderStr);

    if ($pagingOrders->isEmpty())
    {
      Result::fail();
    }

    return Result::pSuccess($pagingOrders);
  }
}