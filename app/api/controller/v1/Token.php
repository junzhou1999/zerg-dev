<?php

namespace app\api\controller\v1;

use app\api\service\ThirdAppToken;
use app\api\service\Token as TokenService;
use app\api\service\WechatUserToken;
use app\api\validate\ThirdAppTokenGet;
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

  /**
   * 对第三方应用比如cms这些应用的登录处理
   * @param $ac
   * @param $se
   * @return \think\response\Json
   * @throws \app\lib\exception\TokenException
   * @throws \think\Exception
   */
  public function getThirdAppToken($ac = '', $se = '') {
    // 验证接口参数
    (new ThirdAppTokenGet())->goCheck();

    // 尝试登录获取token
    $appToken = new ThirdAppToken();
    $token = $appToken->get($ac, $se);

    return json([
        'token' => $token
    ]);
  }
}