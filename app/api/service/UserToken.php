<?php

namespace app\api\service;

use app\lib\exception\WechatException;
use think\Exception;

class UserToken
{
  protected $code;
  protected $wxAppID;
  protected $wxAppSecret;
  protected $wxLoginUrl;

  public function __construct($code) {
    $this->code = $code;
    $this->wxAppID = get_config('wx.app_id');
    $this->wxAppSecret = get_config('wx.app_secret');
    $this->wxLoginUrl = sprintf(get_config('wx.login_url'),
      $this->wxAppID, $this->wxAppSecret, $this->code);
  }

  public function get() {
    $result = curl_get($this->wxLoginUrl);  // 生成json字符串
    $wxResult = json_decode($result, true);  // 转成数组
    if (empty($wxResult)) {
      // 外部异常
      throw new Exception('获取session_key及openID时异常，微信内部错误。');
    }
    else {
      $loginFail = array_key_exists('errcode', $wxResult);
      if ($loginFail)
        processLoginFail($wxResult);
      else
        $this->grantToken($wxResult);
    }
  }

  private function grantToken($wxResult) {
    // 拿到openid
    // 查询数据库，判断openid是否存在
    // 如果存在，则不处理
    // 如果不存在那么新增一条user记录
    // 生成令牌，准备缓存数据，写入缓存
    // 把令牌返回到客户端
  }

  private function processLoginFail($wxResult) {
    throw new WechatException([
      'statusCode' => $wxResult['errcode'],
      'message' => $wxResult['errmsg'],
    ]);
  }
}