<?php

namespace app\admin\controller;
use app\admin\business\Result;
use app\admin\model\Category as CategoryModal;
use app\admin\validate\PagingParameter;

class Category
{
  public function getAll($page=1, $size=10){
    (new PagingParameter())->goCheck();

    $pagingCat = CategoryModal::getCatByPage($page, $size);

    if($pagingCat->isEmpty()) {
      Result::fail();
    }

    return Result::pSuccess($pagingCat);

  }
}