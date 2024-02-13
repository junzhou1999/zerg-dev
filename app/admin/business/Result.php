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
    ];
    return json($rs);
  }

  public static function fail()
  {
    $rs = [
        'code' => 404,
        'msg' => "Not Found!!",
    ];
    return json($rs);
  }

  public static function pSuccess($pagingData)
  {
    $rs = [
      'code' => 200,
      'data' => $pagingData->items(),
      'totals' => $pagingData->total(),
      'cPage' => $pagingData->currentPage(),
      'pSize' => $pagingData->listRows(),
//      'hasMore' => $pagingData->hasMore
    ];

    return json($rs);
  }
}