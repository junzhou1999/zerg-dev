<?php

namespace app\api\service;

use app\api\model\ThirdApp;
use app\lib\exception\TokenException;

class ThirdAppToken extends Token
{

    /**
     * 校验、获取cms端传来的账号密码
     * @param $ac
     * @param $sc
     * @return void
     */
    public function get($ac, $se)
    {
        $app = ThirdApp::check($ac, $se);
        if (!$app) {
            throw new TokenException([
                    'code' => 401,
                    'message' => '授权失败',
                    'statusCode' => 10004
                ]
            );
        }
        // 准备要存进缓存的信息
        $uid = $app->id;
        $scope = $app->scope;
        $values = [
            'uid' => $uid,
            'scope' => $scope
        ];
        $token = $this->saveToCache($values);
        return $token;
    }

}