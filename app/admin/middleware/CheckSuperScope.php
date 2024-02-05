<?php

namespace app\admin\middleware;
use app\admin\service\Token as TokenService;

class CheckSuperScope
{
  public function handle($request, \Closure $next) {
    TokenService::needSuperScope();  // 校验权限
    return $next($request);
  }

}