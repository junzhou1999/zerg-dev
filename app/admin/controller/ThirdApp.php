<?php

namespace app\admin\controller;

use app\admin\business\Result;
use app\admin\model\ThirdApp as AppModel;
use app\api\validate\IDValidate;
use app\lib\exception\AdminUserException;
use app\lib\exception\MissException;
use app\lib\exception\SuccessMessage;

class ThirdApp
{
  public function getAll()
  {
    $adminUsers = AppModel::limit(20)->select();

    if(!$adminUsers)  throw new MissException();

    return Result::success($adminUsers);
  }

  // 删除
  public function delete($id)
  {
    (new IDValidate())->goCheck();

    $adminUser = AppModel::find($id);
    if (!$adminUser)  throw new AdminUserException();

    $adminUser->delete();

    return json(new SuccessMessage([
        'code' => 200
    ]));
  }
}