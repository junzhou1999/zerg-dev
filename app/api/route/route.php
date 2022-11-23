<?php

use think\facade\Route;

// Banner
Route::get(':version/banner/:id', ':version.Banner/getBanner');

// Theme
Route::get(':version/theme', ':version.Theme/getSimpleList');
