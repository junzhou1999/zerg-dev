<?php

namespace app\api\controller\v1;

use app\api\middleware\CheckExclusiveScope;
use app\api\middleware\CheckPrimaryScope;
use app\api\service\Order as OrderService;
use app\api\service\Token as TokenService;
use app\api\model\Order as OrderModel;
use app\api\validate\IDValidate;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;

class Order
{

  protected $middleware = [
    CheckExclusiveScope::class => ['only' => ['placeOrder']],
    CheckPrimaryScope::class => ['only' => ['getDetail,getSummaryByUser']],
  ];

  /**
   * @url /order/
   * 下单
   */
  public function placeOrder() {
    (new OrderPlace())->goCheck();
    $products = input('post.products/a');  // 获取body的所有products
    $uid = TokenService::getCurrentTokenVar('uid');
    $service = new OrderService();
    $status = $service->place($uid, $products);
    return json($status);
  }

  /**
   * 获取订单详情
   * @param $id
   * @return static
   * @throws OrderException
   * @throws \app\lib\exception\ParameterException
   */
  public function getDetail($id)
  {
    (new IDValidate())->goCheck();
    $orderDetail = OrderModel::find($id);
    if (!$orderDetail)
    {
      throw new OrderException();
    }
    return $orderDetail
        ->hidden(['prepay_id']);
  }

  /**
   * 根据用户id分页获取订单列表（简要信息）
   * @param int $page
   * @param int $size
   * @return array
   * @throws \app\lib\exception\ParameterException
   */
  public function getSummaryByUser($page = 1, $size = 15)
  {
    (new PagingParameter())->goCheck();
    $uid = TokenService::getCurrentUid();
    $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
    if ($pagingOrders->isEmpty())
    {
      return json_encode([
          'current_page' => $pagingOrders->currentPage(),
          'data' => []
      ]);
    }
  //        $collection = collection($pagingOrders->items());
  //        $data = $collection->hidden(['snap_items', 'snap_address'])
  //            ->toArray();
    $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
        ->toArray();
    return json([
        'current_page' => $pagingOrders->currentPage(),
        'data' => $data
    ]);
  }

  /**
   * 获取全部订单简要信息（分页）
   * @param int $page
   * @param int $size
   * @return array
   * @throws \app\lib\exception\ParameterException
   */
  public function getSummary($page=1, $size = 20){
    (new PagingParameter())->goCheck();
//        $uid = Token::getCurrentUid();
    $pagingOrders = OrderModel::getSummaryByPage($page, $size);
    if ($pagingOrders->isEmpty())
    {
      return json([
          'current_page' => $pagingOrders->currentPage(),
          'data' => []
      ]);
    }
    $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
        ->toArray();
    return json([
        'current_page' => $pagingOrders->currentPage(),
        'data' => $data
    ]);
  }
}