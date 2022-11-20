<?php

namespace app\lib\exception;

/**
 * Class ParameterException
 * 通用参数类异常错误
 */
class ParameterException extends BaseException
{
  public $code = 400;
  public $message = "invalid parameters";
  public $statusCode = 10000;
}