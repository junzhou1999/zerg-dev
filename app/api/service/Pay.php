<?php

namespace app\api\service;

use think\Exception;

class Pay
{
  private $orderID;
  private $orderNO;

  function __construct($orderID)
  {
    if (!$orderID)
    {
      throw new Exception('订单号不允许为NULL');
    }
    $this->orderID = $orderID;
  }

  // 支付的主方法
  public function pay(){

  }

}