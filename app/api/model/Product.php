<?php

namespace app\api\model;

class Product extends BaseModel
{
  // pivot：多对多产生的中间表、数据
  protected $hidden = [
    'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
    'create_time', 'update_time'];

  public function getMainImgUrlAttr($value, $data) {
    return $this->prefixImgUrl($value, $data);
  }

  public static function getMostRecent($count = 15) {
    $products = self::limit($count)
      ->order('create_time', 'desc')
      ->select();
    return $products;
  }

  public static function getProductByCategoryID($categoryID) {
    $products = self::where('category_id', '=', $categoryID)
      ->select();
    return $products;
  }

  public static function getProductDetail($id) {
//    $product = self::with(['imgs.imgUrl' ,'properties']);
    $product = self::with([
      'imgs' => function ($query) {  // 使用闭包查询ProductImage中间表下的url以及对其排序
        $query->with('imgUrl')
          ->order('order', 'asc');
      }, 'properties'])
      ->find($id);
    return $product;
  }

  public function imgs() {
    return $this->hasMany(ProductImage::class, 'product_id', 'id');
  }

  public function properties() {
    return $this->hasMany(ProductProperty::class, 'product_id', 'id');
  }

  public static function getProductByName($name) {
    $products = self::whereRaw('name ~* :name', ['name' => $name])
      ->limit(20)
      ->select();
    return $products;
  }
}