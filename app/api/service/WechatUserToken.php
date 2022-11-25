<?php

namespace app\api\service;

use app\api\model\WechatUser as UserModel;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WechatException;
use think\Exception;
use think\facade\Cache;

class WechatUserToken extends Token
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
        $this->processLoginFail($wxResult);
      else
        // 通过微信服务器登录凭证校验
        return $this->grantToken($wxResult);
    }
  }

  /**
   * 颁发令牌
   * 只要调用登陆就颁发新令牌
   * 但旧的令牌依然可以使用
   * 所以通常令牌的有效时间比较短
   * @param $wxResult
   * @return string
   * @throws TokenException
   * @throws \Psr\SimpleCache\InvalidArgumentException
   */
  private function grantToken($wxResult) {
    $openid = $wxResult['openid'];
    // 查询数据库，判断openid是否存在
    $user = UserModel::getByOpenID($openid);
    // 如果存在，则不处理
    if ($user)  // 微信校验服务器openid在同一用户同一程序下是一致的
      $uid = $user['id'];
    else       // 如果不存在那么新增一条user记录
      $uid = $this->newUser($openid);
    // 准备缓存数据
    $cachedValue = $this->prepareCacheValue($wxResult, $uid);
    // 生成令牌，写入缓存，把令牌返回到客户端
    return $this->saveToCache($cachedValue);
  }

  /**
   * 把令牌跟用户信息放到缓存里
   * @param $cachedValue
   * @return string
   * @throws TokenException
   * @throws \Psr\SimpleCache\InvalidArgumentException
   */
  private function saveToCache($cachedValue) {
    // 生成令牌
    $token = self::make_token();
    $value = json_encode($cachedValue);
    // 过期时间在配置文件
    $result = Cache::store('redis')->set($token, $value);
    if (!$result) {
      throw new TokenException([
        'message' => '服务器缓存异常！',
        'statusCode' => 10005,
      ]);
    }
    return $token;
  }

  /**
   * 整合session_key,openid,uid,scope
   * 生成令牌value
   * @param $wxResult
   * @param $uid
   * @return mixed
   */
  private function prepareCacheValue($wxResult, $uid) {
    $cachedValue = $wxResult;
    $cachedValue['uid'] = $uid;
    $cachedValue['scope'] = ScopeEnum::USER;   // App用户的权限数组
    //$cachedValue['scope'] = ScopeEnum::SUPER;  // CMS（管理员）用户的权限
    return $cachedValue;
  }

  /**
   * 获取用户在数据库的id主键
   * @param $openid
   * @return mixed
   */
  private function newUser($openid) {
    $user = UserModel::create(['openid' => $openid]);
    return $user['id'];
  }

  private function processLoginFail($wxResult) {
    throw new WechatException([
      'statusCode' => $wxResult['errcode'],
      'message' => $wxResult['errmsg'],
    ]);
  }
}