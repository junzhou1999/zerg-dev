<?php

namespace app\api\controller\v1;

use app\api\validate\IDValidate;

class Banner
{
  /**
   * 根据id号获取id信息
   * @return string
   */
  public function getBanner($id) {
    $validate = new IDValidate();  // 异常检测，相当于拦截器
    $validate->goCheck();
    return 'res';
  }

}