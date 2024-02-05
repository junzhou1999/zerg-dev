<?php

namespace app\admin\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Exception;
use think\facade\Cache;
use think\facade\Request;

class Token
{
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

  // 管理员用户权限校验
  public static function needSuperScope() {
    $scope = self::getCurrentTokenVar('scope');
    if (!$scope)
      throw new TokenException();
    if ($scope != ScopeEnum::SUPER)
      throw new ForbiddenException();
    return false;
  }
}