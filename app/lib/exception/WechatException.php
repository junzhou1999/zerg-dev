<?php

namespace app\lib\exception;

class WechatException extends BaseException
{
  // 微信服务器异常
  public $code = 500;
  public $message = 'wechat unknown error';
  public $statusCode = 99999;
}