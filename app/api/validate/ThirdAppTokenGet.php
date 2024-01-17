<?php

namespace app\api\validate;

class ThirdAppTokenGet extends BaseValidate
{
  /**
   * @var string[] 有key但可以不传值|传的值不能为空
   */
  protected $rule = [
    'ac' => 'require|isNotEmpty',
    'se' => 'require|isNotEmpty'
  ];

}