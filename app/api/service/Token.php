<?php

namespace app\api\service;

class Token
{
  //生成一个不会重复的字符串
  public static function make_token() {
    $str = md5(uniqid(md5(microtime(true)), true));
    $str = sha1($str); //加密
    return $str;
  }
}