<?php

namespace app\api\controller\v1;

use app\api\model\Product as ProductModal;
use app\api\validate\Count;
use app\api\validate\IDValidate;
use app\api\validate\ProdName;
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
    $products = $products->hidden(['summary'], true);
    return json($products);
  }

  /**
   * 根据类目ID获取该类目下所有商品
   * @url /product?id=:
   */
  public function getAllInCategory($id) {
    (new IDValidate())->goCheck();

    $products = ProductModal::getProductByCategoryID($id);
    if ($products->isEmpty()) {
      throw new ProductException();
    }
    $products = $products->hidden(['summary'], true);
    return json($products);
  }

  /**
   * @url /product/:id
   * @param $id
   * @return void
   */
  public function getOne($id) {
    (new IDValidate())->goCheck();

    $product = ProductModal::getProductDetail($id);
    if (!$product) {
      throw new ProductException();
    }
    return json($product);
  }

  public function getByName($name) {
    (new ProdName())->goCheck();
    $products = ProductModal::getProductByName($name);
    if (!$products) {
      throw new ProductException([
        'message' => '暂无此商品哦！'
      ]);
    }
    return json($products);
  }
}