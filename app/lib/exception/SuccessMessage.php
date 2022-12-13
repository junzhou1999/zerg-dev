<?php

namespace app\lib\exception;

class SuccessMessage extends BaseException
{
  // 微信服务器异常
  public $code = 201;
  public $message = 'ok';
  public $statusCode = 0;
}