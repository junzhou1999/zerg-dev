<?php

namespace app\api\validate;

use app\lib\exception\ParameterException;
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
      throw new ParameterException([
        // 批量校验错误的信息可能是个数组
        "message" => is_array($this->error) ?
          implode(';', $this->error) : $this->error,
      ]);
    }
    return true;
  }

  protected function isPositiveInt($value = '', $rule = '', $data = '', $field = ''): bool {
    if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
      return true;
    }
    return false;
  }

  protected function isNotEmpty($value = ''): bool {
    if (empty($value))
      return false;
    return true;
  }
}