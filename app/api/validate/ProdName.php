<?php

namespace app\api\validate;

class ProdName extends BaseValidate
{
  protected $rule = [
    'name' => 'require',
  ];

}