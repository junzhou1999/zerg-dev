<?php

namespace app\admin\controller;
use app\admin\business\Result;
use app\admin\model\Product as ProductModal;
use app\admin\validate\PagingParameter;
use app\admin\validate\SortFiledValidate;

class Product
{
  public function getAll($page=1, $size=10, $sort_create_time='DESC'){
    (new PagingParameter())->goCheck();
    (new SortFiledValidate())->goCheck();

    // order排序跟分页查询
    $orderStr = 'create_time DESC';
    if(!empty($sort_create_time))  $orderStr='create_time '.$sort_create_time;

    $pagingProds = ProductModal::getAllByPage($page, $size, $orderStr);

    if($pagingProds->isEmpty()) {
      Result::fail();
    }

    return Result::pSuccess($pagingProds);

  }
}