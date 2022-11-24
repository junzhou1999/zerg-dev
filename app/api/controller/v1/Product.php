<?php

namespace app\api\controller\v1;

use app\api\model\Product as ProductModal;
use app\api\validate\Count;
use app\lib\exception\ProductException;

class Product
{
  /**
   * 获取最近新品信息
   * @param $count
   * @return void
   */
  public function getRecent($count = 15) {
    (new Count())->goCheck();

    $products = ProductModal::getMostRecent($count);
    if ($products->isEmpty()) {
      throw new ProductException();
    }
    return json($products);
  }
}