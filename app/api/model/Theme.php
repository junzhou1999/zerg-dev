<?php

namespace app\api\model;

class Theme extends BaseModel
{
  protected $hidden = ['delete_time', 'update_time',
    'head_img_id', 'topic_img_id'];
  // 一对一模型，联系在Theme表
  // 定义模型的关联关系...
  public function topicImg() {
    return $this->belongsTo(Image::class, 'topic_img_id', 'id');
  }

  public function headImg() {
    return $this->belongsTo(Image::class, 'head_img_id', 'id');
  }

  // 多对多模型
  public function products() {
    return $this->belongsToMany(Product::class, 'theme_product',
      'product_id', 'theme_id');
  }

  public static function getThemeWithProducts($id) {
    // 把关系with起来
    $themes = self::with(['products', 'topicImg', 'headImg'])->find($id);
    return $themes;
  }
}