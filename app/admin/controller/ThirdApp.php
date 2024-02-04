<?php

namespace app\admin\controller;

use app\admin\business\Result;
use app\admin\model\ThirdApp as AppModel;
use app\lib\exception\MissException;

class ThirdApp
{
  public function getAll()
  {
    $adminUsers = AppModel::limit(20)->select();

    if(!$adminUsers)  throw new MissException();

    return Result::success($adminUsers, sizeof($adminUsers));
  }
}