<?php

namespace app\admin\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInt',
        'size' => 'isPositiveInt',
        'sort_create_time' => 'isInSort',
        'sort_status' => 'isInSort'
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数',
        'sort_create_time' => '排序字段不符合规范',
        'sort_status' => '排序字段不符合规范',
    ];

    protected function isInSort($value=''){
      if (strtoupper($value)=='ASC' || strtoupper($value)=='DESC' || empty($value))
        return true;
      return false;
    }
}