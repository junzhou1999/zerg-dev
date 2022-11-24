<?php

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
  /**
   * 获取所有的分类列表
   * @url category/all
   * @return string
   */
  public function getAllCategories() {
    $categories = CategoryModel::with('img')->select();
    if ($categories->isEmpty()) {
      throw new CategoryException();
    }
    return json($categories);
  }
}