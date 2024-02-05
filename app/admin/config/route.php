<?php

return [
    'middleware' => [
        // 跨域
        \app\admin\middleware\CORS::class,
        // 管理员权限
        \app\admin\middleware\CheckSuperScope::class,
        ]
];
