<?php

namespace app\api\controller\v1;

use app\api\middleware\CheckExclusiveScope;
use app\api\validate\IDValidate;

class Pay
{
  protected $middleware = [
      CheckExclusiveScope::class => ['only' => ['getPreOrder']]
  ];
  // 请求预订单信息
  public function getPreOrder($id){
    (new IDValidate())->goCheck();

  }

}