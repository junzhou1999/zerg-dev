<?php

namespace app\admin\model;


class ThirdApp extends BaseModel
{
  public static function check($ac, $se)
  {
    $app = self::where('app_id','=',$ac)
        ->where('app_secret', '=',$se)
        ->find();
    return $app;
  }
}