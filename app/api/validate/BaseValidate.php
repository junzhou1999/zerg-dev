<?php

namespace app\api\validate;

use think\Exception;
use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
  /**
   * 参数检测方法
   * @return mixed
   * @throws Exception
   */
  public function goCheck() {
    // 获取请求参数
    $params = Request::param();
    $result = $this->check($params);
    if (!$result) {
      throw new Exception($this->error);
    }
    return true;
  }

  protected function isPositiveInt($value = '', $rule = '', $data = '', $field = ''): bool {
    if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
      return true;
    }
    return false;
  }
}