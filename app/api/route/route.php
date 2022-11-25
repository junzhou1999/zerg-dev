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
Route::get(':version/product/recent', ':version.Product/getRecent');
Route::get(':version/product/by-category', ':version.Product/getAllInCategory');
Route::get(':version/product/:id', ':version.Product/getOne');  // 不分组的话就把复杂的放前面

// Category
Route::get(':version/category/all', ':version.Category/getAllCategories');

// Token
Route::post(':version/token/user', ':version.Token/getToken');

// Address
Route::post(':version/address', ':version.Address/createOrUpdateAddress');

// order
Route::post(':version/order', ':version.Order/placeOrder');

