<?php

namespace app\admin\business;

class Result
{
  public static function success($data)
  {
    $rs = [
      'code' => 200,
      'msg' => "success",
      'data' => $data,
      'total' => sizeof($data)
    ];
    return json($rs);
  }
}