<?php

namespace app\lib\exception;

/**
 * 创建成功（如果不需要返回任何消息）
 * 201 创建成功，202需要一个异步的处理才能完成请求
 */
class SuccessMessage extends BaseException
{
  // 微信服务器异常
  public $code = 201;
  public $message = 'ok';
  public $statusCode = 0;
}