<?php

namespace app\api\model;

class WechatUser extends BaseModel
{
  public static function getByOpenID($openid) {
    $user = self::where('openid', '=', $openid)
      ->find();
    return $user;
  }
}