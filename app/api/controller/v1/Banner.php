<?php

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModal;
use app\api\validate\IDValidate;
use app\lib\exception\MissException;

class Banner
{
  /**
   * 根据id号获取id信息
   * @return string
   */
  public function getBanner($id) {
    $validate = new IDValidate();  // 异常检测，相当于拦截器
    $validate->goCheck();
    $banner = BannerModal::getBannerByID($id);
    if (!$banner) {
      throw new MissException([
        'statusCode' => 40000,
        'message' => '请求banner不存在',
      ]);
    }
    return $banner;
  }

}