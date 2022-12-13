<?php

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;
use app\api\service\WechatUserToken;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;

class Token
{
  public function getToken($code = '') {
    (new TokenGet())->goCheck();

    $ut = new WechatUserToken($code);
    $token = $ut->get();
    return json([
      'token' => $token
    ]);
  }

  public function verifyToken($token = '') {
    if (!$token) {
      throw new ParameterException([
        'message' => 'token不允许为空'
      ]);
    }
    $valid = TokenService::verifyToken($token);
    return json([
      'isValid' => $valid
    ]);
  }
}