<?php

namespace app\lib\exception;

class WechatUserException extends BaseException
{
  // 无法通过token获取到user
  public $code = 404;
  public $message = '用户不存在';
  public $statusCode = 60000;
}