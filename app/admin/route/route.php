<?php

use think\facade\Route;

Route::get('hello','Index/index');

Route::group('/user', function(){
  Route::get('', 'ThirdApp/getAll');  // 查看管理员用户列表
  Route::delete('','ThirdApp/delete');
});

// 获取token
Route::post('/token/app', 'Token/getThirdAppToken');
