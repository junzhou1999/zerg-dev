<?php

namespace app\api\validate;

class IDValidate extends BaseValidate
{
  protected $rule = [
    'id' => 'require|isPositiveInt',
  ];

  protected $message = [
    'id.isPositiveInt' => 'id必须是正整数',
  ];
}