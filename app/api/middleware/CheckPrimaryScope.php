<?php

namespace app\api\middleware;

use app\api\service\Token as TokenService;

class CheckPrimaryScope
{
  public function handle($request, \Closure $next) {
    TokenService::needPrimaryScope();
    return $next($request);  // 前置中间件
  }
}