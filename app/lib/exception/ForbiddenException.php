<?php

namespace app\lib\exception;

class ForbiddenException extends BaseException
{
  public $code = 403;
  public $message = 'ζιδΈε€';
  public $statusCode = 10001;
}