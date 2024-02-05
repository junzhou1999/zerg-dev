<?php

namespace app\admin\middleware;
use app\admin\service\Token as TokenService;

class CheckSuperScope
{
  // 路由中间件才可以获取到控制器
  public function handle($request, \Closure $next) {
    #获取当前应用
    $appname = app('http')->getName();
    #当前控制器
    $controller = $request->controller();
    #当前操作
    $action = $request->action();

    #自动定位到控制器，取出设置的变量
    $class = "\app\\{$appname}\controller\\{$controller}";
    $model = new $class($request);

    #跳过中间件的设置
    if(
        property_exists($model, 'noCheckScope')
        &&
        $model->noCheckScope
        &&
        in_array($action,$model->noCheckScope))
    return $next($request);

    TokenService::needSuperScope();  // 校验权限
    return $next($request);
  }

}