<?php

namespace app\admin\model;

class Image extends BaseModel
{
  protected $hidden = ['id', 'delete_time', 'update_time'];

  // 获取器
  public function getUrlAttr($value, $data) {
    return $this->prefixImgUrl($value, $data);
  }

  public static function getMediaByPage($page=1, $size=10){
    $pagingData = self::paginate(['page' => $page, 'list_rows' => $size], false);

    return $pagingData ;
  }

}