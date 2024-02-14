<?php

namespace app\admin\validate;

class SortFiledValidate extends BaseValidate
{
  protected $rule = [
      'sort_create_time' => 'isInSort',
      'sort_status' => 'isInSort'
  ];

  protected $message = [
      'sort_create_time' => '排序字段不符合规范',
      'sort_status' => '排序字段不符合规范',
  ];

  protected function isInSort($value=''){
    if (strtoupper($value)=='ASC' || strtoupper($value)=='DESC' || empty($value))
      return true;
    return false;
  }
}