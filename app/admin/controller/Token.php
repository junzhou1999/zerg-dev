<?php

namespace app\admin\controller;

use app\admin\service\ThirdAppToken as AppTokenService;
use app\admin\validate\ThirdAppTokenGet;

class Token
{

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
    $appToken = new AppTokenService();
    $token = $appToken->get($ac, $se);

    return json([
        'token' => $token
    ]);
  }
}