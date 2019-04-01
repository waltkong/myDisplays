<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/31
 * Time: 1:24
 */

namespace app;

use app\middlewares\AuthMiddleware;
use app\middlewares\ExceptMiddleware;
use app\middlewares\ThrottleMiddleware;

class Kernel
{

    public $middleware = [
        [
            'sort' => 1,           //优先级
            'scope' => 'global',    //作用域可选值 【global module controller action】
            'type' => 'before',     //前置还是后置中间件  暂时只支持 ‘before’
            'route'  =>  [],       //被注册的路由
            'class' => AuthMiddleware::class,    //中间件具体逻辑处理
        ],
        [
            'sort' => 2,           //优先级
            'scope' => 'global',    //作用域可选值 【global module controller action】
            'type' => 'before',     //前置还是后置中间件  暂时只支持 ‘before’
            'route'  =>  [],       //被注册的路由
            'class' => ExceptMiddleware::class,    //中间件具体逻辑处理
        ],
        [
            'sort' => 3,           //优先级
            'scope' => 'global',    //作用域可选值 【global module controller action】
            'type' => 'before',     //前置还是后置中间件  暂时只支持 ‘before’
            'route'  =>  [],       //被注册的路由
            'class' => ThrottleMiddleware::class,    //中间件具体逻辑处理
        ],
    ];

}