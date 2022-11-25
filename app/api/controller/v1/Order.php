<?php

namespace app\api\controller\v1;

use app\api\middleware\CheckExclusiveScope;

class Order
{

  protected $middleware = [
    CheckExclusiveScope::class => ['only' => ['placeOrder']],
  ];

  /**
   * @url /order/
   * 下单
   */
  public function placeOrder() {
    return "success";
  }
}