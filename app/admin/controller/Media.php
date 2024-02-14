<?php

namespace app\admin\controller;
use app\admin\business\Result;
use \app\admin\model\Image as ImageModel;
use app\admin\validate\PagingParameter;

class Media
{
  public function getAll($page=1, $size=20){
    // 参数校验
    (new PagingParameter())->goCheck();

    $pagingData = ImageModel::getMediaByPage($page, $size);
    if ($pagingData->isEmpty()) {
      Result::fail();
    }

    return Result::pSuccess($pagingData);
  }

}