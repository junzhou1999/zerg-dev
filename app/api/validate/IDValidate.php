<?php

namespace app\api\validate;

class IDValidate extends BaseValidate
{
  protected $rule = [
    'id' => 'require|isPositiveInt',
    'num' => 'in:1,2,3',
  ];

  protected $message = [
    'id.isPositiveInt' => 'id必须是正整数',
    'num.in' => 'num只能在1，2，3选择'
  ];
}