<?php

namespace app\api\middleware;

class CORS
{
  // 前置全局解决跨域
  public function handle($request, \Closure $next) {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: POST,GET,PUT');
    if ($request->isOptions()) {
      return response()->code(204);
    }

    return $next($request);  // 前置中间件
  }
}