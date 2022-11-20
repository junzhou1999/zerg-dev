<?php

namespace app\lib\exception;

use app\facade\StatusCode;
use think\Exception;

class BaseException extends Exception
{
  public $code = 500;
  public $message = "对不起, 服务器内部异常(*￣︶￣)!";
  public $statusCode = 99999;

  public function __construct($params = []) {
    if (!is_array($params)) {
      return;
    }
    if (array_key_exists('code', $params)) {
      $this->code = $params['code'];
    }
    if (array_key_exists('message', $params)) {
      $this->message = $params['message'];
    }
    if (array_key_exists('statusCode', $params)) {
      $this->statusCode = $params['statusCode'];
    }
  }


}