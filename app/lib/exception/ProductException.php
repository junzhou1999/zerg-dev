<?php

namespace app\lib\exception;

class ProductException extends BaseException
{
  public $code = 404;
  public $message = '指定商品不存在，请检查商品ID';
  public $statusCode = 20000;
}