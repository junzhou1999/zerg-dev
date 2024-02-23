<?php

namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Exception;
use think\facade\Cache;
use think\facade\Request;

class Token
{
  /**
   * @param $key 通过指定key获取token信息里面的值
   * @return void
   * @throws TokenException
   * @throws \Psr\SimpleCache\InvalidArgumentException
   */
  public static function getCurrentTokenVar($key) {
    $token = Request::header('token');
    $vars = Cache::store('redis')->get($token);
    if (!$vars) {
      throw new TokenException();
    }
    else {
      if (!is_array($vars))
        $vars = json_decode($vars, true);
      if (array_key_exists($key, $vars))
        return $vars[$key];
      throw new Exception('尝试获取的Token变量并不存在');
    }
  }

  public static function getCurrentUid() {
    $uid = self::getCurrentTokenVar('uid');
    return $uid;
  }

  /*
   * 验证token是否过期
   * scope权限是用户及以上
   */
  public static function needPrimaryScope() {
    $scope = self::getCurrentTokenVar('scope');
    if (!$scope)
      throw new TokenException();
    if ($scope < ScopeEnum::USER)
      throw new ForbiddenException();
    return false;
  }

  // 用户专有权限
  public static function needExclusicveScope() {
    $scope = self::getCurrentTokenVar('scope');
    if (!$scope)
      throw new TokenException();
    if ($scope != ScopeEnum::USER)
      throw new ForbiddenException();
    return false;
  }

  public static function verifyToken($token) {
    $exist = Cache::get($token);
    if ($exist) {
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * 当前操作是否为本身用户
   * @return bool
   */
  public static function isValidateOperate($checkedUID){
    if(!$checkedUID){
      throw new Exception('检查UID时必须传入一个被检查的UID');
    }
    $currentOperateUID = self::getCurrentUid();
    if($currentOperateUID == $checkedUID){
      return true;
    }
    return false;
  }

    /**
     * 把令牌跟用户信息放到缓存里
     * @param $cachedValue
     * @return string
     * @throws TokenException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function saveToCache($cachedValue) {
        // 生成令牌
        $token = make_token();
        $value = json_encode($cachedValue);
        // 过期时间在配置文件
        $result = Cache::store()->set($token, $value);
        if (!$result) {
            throw new TokenException([
                'message' => '服务器缓存异常！',
                'statusCode' => 10005,
            ]);
        }
        return $token;
    }
}