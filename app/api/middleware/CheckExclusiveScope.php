<?php

namespace app\api\middleware;

use app\api\service\Token as TokenService;

class CheckExclusiveScope
{
  public function handle($request, \Closure $next) {
    TokenService::needExclusicveScope();
    return $next($request);  // 前置中间件
  }
}