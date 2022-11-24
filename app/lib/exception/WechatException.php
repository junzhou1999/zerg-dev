<?php

namespace app\lib\exception;

class WechatException extends BaseException
{
  public $code = 500;
  public $message = 'wechat unknown error';
  public $statusCode = 99999;
}