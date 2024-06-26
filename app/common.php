<?php
// 应用公共文件

use think\facade\Config;

/**
 * 框架使用curl来进行http请求
 * @param string $url get请求地址
 * @param int $httpCode 返回状态码
 * @return mixed
 */
function curl_get($url, &$httpCode = 0) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  //不做证书校验,部署在linux环境下请改为true
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  $file_contents = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return $file_contents;
}

// 读取文件配置
function get_config($key) {
  return Config::get($key);
}

///// 把token业务提到全局
//生成一个不会重复的字符串
function make_token() {
  $str = md5(uniqid(md5(microtime(true)), true));
  $str = sha1($str); //加密
  return $str;
}