<?php

namespace app\api\controller\v1;

use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollectionValidate;
use app\api\validate\IDValidate;
use app\lib\exception\ThemeException;

class Theme
{
  /**
   * 获取主题列表，idx只能匹配到数据库存在的id
   * @url /theme?ids=id1,id2,id3...
   * @param $ids , id1,id2,id3...
   * @return void
   */
  public function getSimpleList($ids) {
    $validate = new IDCollectionValidate();
    $validate->goCheck();

    // 业务简单直接写在controller层
    $ids = explode(',', $ids);
    $res = ThemeModel::with(['topicImg', 'headImg'])
      ->select($ids);
    if ($res->isEmpty()) {
      throw new ThemeException();
    }
    return json($res);
  }

  /**
   * @url /theme/:id
   * @param $id
   * @return theme列表
   */
  public function getComplexOne($id) {
    $validate = new IDValidate();
    $validate->goCheck();

    $theme = ThemeModel::getThemeWithProducts($id);
    if (!$theme)
      throw new ThemeException();
    return json($theme);
  }
}