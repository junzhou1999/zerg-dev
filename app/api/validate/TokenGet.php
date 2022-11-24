<?php

namespace app\api\validate;

class TokenGet extends BaseValidate
{
  /**
   * @var string[] 有key但可以不传值|传的值不能为空
   */
  protected $rule = [
    'code' => 'require|isNotEmpty',
  ];

  protected $message = [
    'code.isNotEmpty' => '没有code还想获token，做梦吧~',
  ];
}