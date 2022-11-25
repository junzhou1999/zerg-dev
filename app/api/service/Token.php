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
  //生成一个不会重复的字符串
  public static function make_token() {
    $str = md5(uniqid(md5(microtime(true)), true));
    $str = sha1($str); //加密
    return $str;
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

}