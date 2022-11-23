<?php

use think\facade\Route;

// Banner
Route::get(':version/banner/:id', ':version.Banner/getBanner');

// Theme
Route::group(':version/theme', function () {
  Route::get('', ':version.Theme/getSimpleList');
  Route::get('/:id', ':version.Theme/getComplexOne');
});

