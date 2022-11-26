<?php

namespace app\api\validate;

use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
  /*
  {
    "products":[{
      "product_id":1,
      "count":1
    },
    {
      "product_id":1,
      "count":1
    }]
  }
   */
  protected $rule = [
    'products' => 'checkProducts',
  ];

  protected $singleRule = [
    'product_id' => 'require|isPositiveInt',       // 一个订单商品id
    'count' => 'require|isPositiveInt',            // 一个订单商品数量
  ];

  protected function checkProducts($values) {
    if (empty($values)) {
      throw new ParameterException([  // 进入check里面，如果深层抛出异常，也就停止结束了
        'message' => '商品列表不能为空',
      ]);
    }
    if (!is_array($values)) {
      throw new ParameterException([
        'message' => '商品参数不正确',
      ]);
    }
    foreach ($values as $value) {
      $this->checkProduct($value);
    }
    return true;
  }

  /*
   * 校验订单内每个商品信息
   */
  private function checkProduct($value) {
    $validate = new BaseValidate();
    $validate->rule($this->singleRule);
    $result = $validate->check($value);  // 校验并返回校验结果
    if (!$result) {
      throw new ParameterException([
        'message' => '商品列表参数错误',
      ]);
    }
  }

}