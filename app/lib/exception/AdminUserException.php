<?php

namespace app\lib\exception;

class AdminUserException extends BaseException
{
  // 无法获取管理员用户
  public $code = 404;
  public $message = '管理员用户不存在';
  public $statusCode = 70000;
}