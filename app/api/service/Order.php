<?php

namespace app\api\service;

use app\api\model\Product as ProductModel;
use app\lib\exception\OrderException;

class Order
{
  protected $oProducts;    // 客户端传进来的商品信息
  protected $ProductsDb;   // 真实的商品信息
  protected $uid;          // 用户id

  public function place($uid, $oProducts) {
    $this->uid = $uid;
    $this->oProducts = $oProducts;
    $this->ProductsDb = $this->getProductsByOrder($this->oProducts);

    $status = $this->getOrderStatus();
    if (!$status['pass']) {
      $status['oeder_id'] = -1;
      return $status;
    }

    // 开始创建订单
  }

  /**
   * 判断订单可支付状态
   */
  private function getOrderStatus() {
    // 二维数组
    $status = [
      'pass' => true,
      'order_price' => 0,
      'pStatusArray' => []
    ];
    foreach ($this->oProducts as $product) {
      // 获取每个订单商品支付状态
      $pStatus = $this->getProductStatus($product['product_id'],
        $product['count'], $this->ProductsDb);
      // 一个商品没有库存的话，订单失效
      if (!$pStatus['haveStock']) $pStatus['pass'] = false;
      $status['order_price'] += $pStatus['totalPrice'];
      array_push($status['pStatusArray'], $pStatus);
    }
    return $status;
  }

  /**
   * 判断订单内每个商品可支付状态
   * @param $oPID
   * @param $oCount 一个下单商品的数量
   * @param $productsDb  一维关联数组
   * @return void
   */
  private function getProductStatus($oPID, $oCount, $productsDb) {
    $pIndex = -1;  // 下单商品在数据库中的索引
    // 匹配到的商品的状态
    $pStatus = [
      'id' => null,
      'haveStock' => false,
      'count' => 0,
      'name' => '',
      'totalPrice' => 0
    ];

    for ($i = 0; $i < count($productsDb); $i++) {
      // 判断商品库存量
      if ($oPID == $productsDb[$i]['id']) {
        $pIndex = $i;
        break;
      }
    }
    if ($pIndex == -1) {
      throw new OrderException([
        'message' => 'id为' . $oPID . '的商品不存在，订单创建失败'
      ]);
    }
    else {
      $product = $productsDb[$pIndex];
      $pStatus['id'] = $product['id'];
      $pStatus['name'] = $product['name'];
      $pStatus['count'] = $oCount;
      $pStatus['totalPrice'] = $product['price'] * $oCount;
      if ($product['stock'] >= $oCount) $pStatus['haveStock'] = true;
      return $pStatus;
    }
  }

  /**
   * 根据下单信息查询数据库真实商品信息
   * @param $oProducts
   * @return 返回一个商品信息
   */

  private function getProductsByOrder($oProducts) {
    $oPIDs = [];
    // 不能一个一个的拿pid查询数据库，用in一次性查询
    foreach ($oProducts as $item) {
      array_push($oPIDs, $item['product_id']);  // 二维数组
    }
    $products = ProductModel::select($oPIDs)
      ->visible(['id', 'name', 'price', 'stock', 'main_img_url'])
      ->toArray();   // 查询到的模型转成数组
    return $products;
  }

}