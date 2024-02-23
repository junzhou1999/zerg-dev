<?php

namespace app\api\service;

use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\service\Order as OrderService;
use \app\api\model\Order as OrderModel;
use \app\api\service\Token as TokenService;

class Pay
{
  private $orderID;
  private $orderNO;

  function __construct($orderID)
  {
    if (!$orderID)
    {
      throw new Exception('订单号不允许为NULL');
    }
    $this->orderID = $orderID;
  }

  // 支付的主方法
  public function pay($orderID){
    $this->checkOrderValidate();  // 先检测订单状况，用户，最后再检测库存

    $orderService = new OrderService();
    $status = $orderService->checkOrderStock($orderID);

    if(!$status['pass'])    return $status;

  }

  /**
   * 根据容易出现的判断情况，判断所消耗的服务器性能
   * @return 检测结果对象
   */
  private function checkOrderValidate(){
    // 订单不存在
    $order = OrderModel::where('id', $this->orderID)->find();
    if (!$order)  throw new OrderException();

    // 订单号不属于用户
    if (!TokenService::isValidateOperate($order->user_id)){
      throw new TokenException([
          'message' => '订单与用户不匹配',
          'statusCode' => 10003
      ]);
    }

    // 订单已被支付
    if($order->status != OrderStatusEnum::UNPAID){
      throw new OrderException([
          'code' => 400,
          'message' => '订单已支付过啦',
          'statusCode' => 80003
      ]);
    }
    $this->orderNO = $order->order_no;
    return true;
  }



}