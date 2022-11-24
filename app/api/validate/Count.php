<?php

namespace app\api\validate;

class Count extends BaseValidate
{
  protected $rule = [
    'count' => 'isPositiveInt|between:1,15',
  ];

  protected $message = [
    'count.isPositiveInt' => 'count必须是正整数',
  ];
}