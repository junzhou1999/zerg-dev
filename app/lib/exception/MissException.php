<?php

namespace app\lib\exception;

class MissException extends BaseException
{
  public $code = 404;
  public $message = 'global:your required resource are not found';
  public $statusCode = 10001;
}