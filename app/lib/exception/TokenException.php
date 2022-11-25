<?php

namespace app\lib\exception;

class TokenException extends BaseException
{
  public $code = 401;
  public $message = 'Token已过期或无效Token';
  public $statusCode = 10001;
}