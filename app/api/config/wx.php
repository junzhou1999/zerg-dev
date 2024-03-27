<?php

return [
    //  +---------------------------------
    //  微信相关配置
    //  +---------------------------------

    // 小程序app_id
    'app_id' => 'your appid',
    // 小程序app_secret
    'app_secret' => 'your appsecret',

    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
    // 商家号
    'mchid' => 'your mchid',
    // 私钥证书位置，自定义文件位置
    'mch_private_key' => app()->getAppPath().'extra'.DIRECTORY_SEPARATOR.'WxPay'.DIRECTORY_SEPARATOR.'apiclient_key.pem',
    // 证书序列号
    'mch_serial_no' => 'your mch_serial_no',
    // 微信支付平台证书，自定义文件位置
    'mch_certificate_file' => app()->getAppPath().'extra'.DIRECTORY_SEPARATOR.'WxPay'.DIRECTORY_SEPARATOR.'apiclient_cert.pem'

//
//    // 微信获取access_token的url地址
//    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
//        "grant_type=client_credential&appid=%s&secret=%s",

];
