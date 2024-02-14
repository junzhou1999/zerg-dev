<?php

use think\facade\Route;

Route::get('hello','Index/index');

Route::group('/user', function(){
  Route::get('', 'ThirdApp/getAll');  // 查看管理员用户列表
  Route::delete('','ThirdApp/delete');
});

// 获取token
Route::post('/token/app', 'Token/getThirdAppToken');

// 订单
Route::group('/order', function(){
  Route::get('paginate', 'Order/getSummary');  // 获取订单列表
});

//媒体文件
Route::get('/media/paginate', 'Media/getAll');
