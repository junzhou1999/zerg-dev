<?php

namespace app\admin\business;

class Result
{
  public static function success($data, $total)
  {
    $rs = [
      'code' => 200,
      'msg' => "success",
      'data' => $data,
      'total' => $total
    ];
    return json($rs);
  }
}