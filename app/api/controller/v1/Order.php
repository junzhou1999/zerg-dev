<?php

namespace app\api\controller\v1;

use app\api\middleware\CheckExclusiveScope;
use app\api\service\Token as TokenService;
use app\api\validate\OrderPlace;

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
    (new OrderPlace())->goCheck();
    $products = input('post.products/a');  // 获取body的所有products
    $uid = TokenService::getCurrentTokenVar('uid');
    return "success";
  }
}