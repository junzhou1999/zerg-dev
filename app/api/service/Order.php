<?php

namespace app\api\service;

use app\api\model\Product as ProductModel;
use app\api\model\UserAddress as UserAddressModel;
use app\lib\exception\OrderException;
use app\lib\exception\WechatUserException;

class Order
{
  protected $oProducts;    // 客户端传进来的商品信息
  protected $productsDb;   // 真实的商品信息
  protected $uid;          // 用户id

  public function place($uid, $oProducts) {
    $this->uid = $uid;
    $this->oProducts = $oProducts;
    $this->productsDb = $this->getProductsByOrder($this->oProducts);

    $status = $this->getOrderStatus();
    if (!$status['pass']) {
      $status['oeder_id'] = -1;
      return $status;
    }

    // 开始创建订单
    $orderSnap = $this->snapOrder($status);
  }

  /**
   * 生成订单快照，查询订单的信息需要生成历史快照，直接去数据库的数据会导致数据更新不吻合
   * @return void
   */
  private function snapOrder($status) {
    // 业务需求所需要的信息
    $snap = [
      'orderPrice' => 0,  // 订单总价格
      'totalCount' => 0,  // 商品总数量，不是订单商品数量
      'pStatus' => [],    // 各个商品的状态
      'snapAddress' => null,  // 订单收货地址
      'snapName' => '',   // 订单标题
      'snapImg' => '',    // 订单图片
    ];

    $snap['orderPrice'] = $status['order_price'];
    $snap['totalCount'] = $status['totalCount'];
    $snap['pStatus'] = $status['pStatusArray'];
    // 数组作为字符串放进表字段，索引查找麻烦/建新表？关系复杂/选择nosql文档性数据库？mongodb
    $snap['snapAddress'] = json_encode($this->getUserAddress($this->uid));
    // 选择第一个商品作为快照的标题，图片
    $snap['snapName'] = $this->productsDb[0]['name'];
    $snap['snapImg'] = $this->productsDb[0]['main_img_url'];

    // 明晰订单标题
    if (count($this->productsDb) > 1) {
      $snap['snapName'] .= '等';
    }
    return $snap;
  }

  /**
   * 查询用户地址
   */
  private function getUserAddress($uid) {
    $userAddress = UserAddressModel::where('user_id', '=', $uid)
      ->find();
    if (!$userAddress) {
      throw new WechatUserException([
        'message' => '用户收获地址不存在，下单失败',
        'status_code' => 60001
      ]);
      return $userAddress->toArray();
    }
  }

  /**
   * 判断订单可支付状态
   */
  private function getOrderStatus() {
    // 二维数组
    $status = [
      'pass' => true,       // 订单总的可支付状态
      'order_price' => 0,   // 订单总价格
      'totalCount' => 0,    // 订单总商品数量
      'pStatusArray' => []  // 每个订单支付商品的信息
    ];
    foreach ($this->oProducts as $product) {
      // 获取每个订单商品支付状态
      $pStatus = $this->getProductStatus($product['product_id'],
        $product['count'], $this->productsDb);
      // 一个商品没有库存的话，订单失效
      if (!$pStatus['haveStock'])
        $pStatus['pass'] = false;
      $status['order_price'] += $pStatus['totalPrice'];
      $status['totalCount'] += $pStatus['count'];
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