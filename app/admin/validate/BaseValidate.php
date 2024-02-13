<?php

namespace app\admin\validate;

use app\lib\exception\ParameterException;
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
    $result = $this->batch()->check($params);
    if (!$result) {
      throw new ParameterException([
        // 批量校验错误的信息可能是个数组
          "message" => is_array($this->error) ?
              implode(';', $this->error) : $this->error,
      ]);
    }
    return true;
  }

  // 非空
  protected function isNotEmpty($value = ''): bool {
    if (empty($value))
      return false;
    return true;
  }

  // 校验是否为正数
  protected function isPositiveInt($value = '') {
    if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
      return true;
    }
    return false;
  }
}