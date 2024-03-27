<?php

namespace app\api\service;

use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\service\Order as OrderService;
use \app\api\model\Order as OrderModel;
use \app\api\service\Token as TokenService;

//require_once('vendor/autoload.php');
use WeChatPay\Builder;
use WeChatPay\Crypto\Rsa;
use WeChatPay\Util\PemUtil;

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
  public function pay(){
    $this->checkOrderValidate();  // 先检测订单状况，用户，最后再检测库存

    $orderService = new OrderService();
    $status = $orderService->checkOrderStock($this->orderID);

    if(!$status['pass'])    return $status;
    $this->makeVxPreOrder();
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

  // 构建支付订单信息
  private function makeVxPreOrder(){
    // 获取uid
    $openid = Token::getCurrentTokenVar('openid');
    if(!$openid){
      throw new TokenException();
    }

    // **********SDK************
    // 商户号
    $merchantId = get_config('wx.mchid');
    // 从本地文件中加载「商户API私钥」，「商户API私钥」会用来生成请求的签名
    $merchantPrivateKeyFilePath = 'file://'.get_config('wx.mch_private_key');
    $merchantPrivateKeyInstance = Rsa::from($merchantPrivateKeyFilePath, Rsa::KEY_TYPE_PRIVATE);
    // 「商户API证书」的「证书序列号」
    $merchantCertificateSerial = get_config('wx.mch_serial_no');
    // 从本地文件中加载「微信支付平台证书」(可使用证书下载工具得到），用来验证微信支付应答的签名
    $platformCertificateFilePath = 'file://'.get_config('wx.mch_certificate_file');
    $platformPublicKeyInstance = Rsa::from($platformCertificateFilePath, Rsa::KEY_TYPE_PUBLIC);
    // 从「微信支付平台证书」中获取「证书序列号」
    $platformCertificateSerial = PemUtil::parseCertificateSerialNo($platformCertificateFilePath);
    // 构造一个 APIv3 客户端实例
    $instance = Builder::factory([
        'mchid'      => $merchantId,
        'serial'     => $merchantCertificateSerial,
        'privateKey' => $merchantPrivateKeyInstance,
        'certs'      => [
            $platformCertificateSerial => $platformPublicKeyInstance,
        ],
    ]);

    $resp = $instance
        ->chain('v3/pay/transactions/jsapi')
        ->post(['json' => [
            'mchid'        => get_config('wx.mchid'),
            'out_trade_no' => $this->orderNO,
            'appid'        => get_config('wx.app_id'),
            'description'  => 'Image形象店-深圳腾大-QQ公仔',
            'notify_url'   => 'https://weixin.qq.com/',
            'amount'       => [
                'total'    => 1,
                'currency' => 'CNY'
            ],
            'payer' => ['openid' => $openid],
        ]]);
  }



}