<?php
// 这是系统自动生成的middleware定义文件
return [
  // 跨域
  \app\admin\middleware\CORS::class,

  // 管理员权限，不是管理员细分的权限，仅限管理员应用的权限
  \app\admin\middleware\CheckSuperScope::class
];
