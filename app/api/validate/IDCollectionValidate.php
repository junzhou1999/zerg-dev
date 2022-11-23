<?php

namespace app\api\validate;

class IDCollectionValidate extends BaseValidate
{
  protected $rule = [
    'ids' => 'require|checkIDs',
  ];

  protected $message = [
    'ids.checkIDs' => 'ids参数需要是以逗号分割的多个正整数',
  ];

  protected function checkIDs($value = '') {
    $values = explode(',', $value);   // 先把字符串转成数组
    if (empty($values)) {
      return false;
    }
    foreach ($values as $id) {
      if (!$this->isPositiveInt($id)) {
        return false;
      }
    }
    return true;
  }
}