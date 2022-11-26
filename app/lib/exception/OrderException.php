<?php

namespace app\lib\exception;

class OrderException extends BaseException
{
  public $code = 404;
  public $message = '订单不存在，请检查ID';
  public $statusCode = 80000;
}