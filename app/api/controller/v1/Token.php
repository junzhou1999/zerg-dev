<?php

namespace app\api\controller\v1;

use app\api\service\WechatUserToken;
use app\api\validate\TokenGet;

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
}