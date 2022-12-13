<?php

namespace app\api\controller\v1;

use app\api\middleware\CheckPrimaryScope;
use app\api\model\UserAddress;
use app\api\model\WechatUser as UserModel;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\WechatUserException;

class Address
{
  // 使用中间件
  protected $middleware = [
    CheckPrimaryScope::class => ['only' => ['createOrUpdateAddress', 'deleteAddress']],
  ];


  /**
   * 获取用户地址信息
   * @return UserAddress
   * @throws UserException
   */
  public function getUserAddress() {
    $uid = TokenService::getCurrentUid();
    $userAddress = UserAddress::where('user_id', $uid)
      ->find();
    if (!$userAddress) {
      throw new WechatUserException([
        'message' => '用户地址不存在',
        'statusCode' => 60001
      ]);
    }
    return json($userAddress);
  }

  /**
   * @url /address
   * uid一定要从当前token在缓存中找到，不使用传来的uid
   * 对传进来的参数进行校验并且过滤
   */
  public function createOrUpdateAddress() {
    $validate = new AddressNew();
    $validate->goCheck();

    // Token获取uid
    $uid = TokenService::getCurrentUid();
    $user = UserModel::find($uid);
    if (!$user)
      throw new WechatUserException();  // 无法根据token找到用户信息，内部异常

    // 获取user关联的Address模型对象
    $userAddress = $user->address;
    // 根据规则取字段是很有必要的，防止恶意更新非客户端字段
    $data = $validate->getDataByRule(input('post.')); // 获取输入数据
    if (!$userAddress) {
      // 关联属性不存在，则新建
      $user->address()
        ->save($data);
    }
    else {
      // 存在则更新
      // 新增的save方法和更新的save方法并不一样
      // 新增的save来自于关联关系
      // 更新的save来自于模型
      $user->address->save($data);
    }
    return json(new SuccessMessage(), 201);
  }

  public function deleteUserAddress() {
    $uid = TokenService::getCurrentUid();
    $userAddress = UserAddress::where('user_id', $uid)
      ->find();
    if (!$userAddress) {
      throw new WechatUserException([
        'message' => '用户地址不存在',
        'statusCode' => 60001
      ]);
    }
    $userAddress->delete();
    return json(new SuccessMessage([
      'code' => 200
    ]));
  }

}