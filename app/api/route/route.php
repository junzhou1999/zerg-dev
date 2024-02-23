<?php

use think\facade\Route;

// Banner
Route::get(':version/banner/:id', ':version.Banner/getBanner');

// Theme
Route::group(':version/theme', function () {
  Route::get('', ':version.Theme/getSimpleList');
  Route::get('/:id', ':version.Theme/getComplexOne');
});

// Product
//Route::get(':version/product/recent', ':version.Product/getRecent');
//Route::get(':version/product/by-category', ':version.Product/getAllInCategory');
//Route::get(':version/product/:id', ':version.Product/getOne');  // 不分组的话就把复杂的放前面
Route::group(':version/product', function () {
  Route::get('/by-category', ':version.Product/getAllInCategory');
  Route::get('/by-name/:name', ':version.Product/getByName');
  Route::get('/recent', ':version.Product/getRecent');
  Route::get('/:id', ':version.Product/getOne');
});

// Category
Route::get(':version/category/all', ':version.Category/getAllCategories');

// Token
Route::post(':version/token/user', ':version.Token/getToken');
Route::post(':version/token/verify', ':version.Token/verifyToken');
//Route::post(':version/token/app', ':version.Token/getThirdAppToken');

// Address
Route::post(':version/address', ':version.Address/createOrUpdateAddress');
Route::get(':version/address', ':version.Address/getUserAddress');
Route::get(':version/address/:id', ':version.Address/getUserAddressById');
Route::delete(':version/address/:id', ':version.Address/deleteUserAddress');

// 下单
Route::post(':version/order', ':version.Order/placeOrder');

// 获取订单预支付信息
Route::post(':version/pay/pre_order', ':version.Pay/getPreOrder');

// 前端展示路由
Route::get(':version/order/by_user', ':version.Order/getSummaryByUser');
Route::get(':version/order/:id', ':version.Order/getDetail')->pattern(['id'=>'\d+']);
