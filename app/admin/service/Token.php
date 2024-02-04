<?php

namespace app\admin\service;

use app\lib\exception\TokenException;
use think\facade\Cache;

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
}