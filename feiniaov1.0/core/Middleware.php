<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/31
 * Time: 0:25
 */

class Middleware
{

    //默认加载的中间件
    protected $handlers = [];
    //执行时传递给每个中间件的参数
    protected $arguments = [];

    //设置在中间件中传输的参数
    public function send(...$arguments){
        $this->arguments = $arguments;
        return $this;
    }

    //设置经过的中间件
    public function through($handle){
        $this->handlers = is_array($handle) ? $handle : func_get_args(); //func_get_args所有的参数，数组
        return $this;
    }

    //运行中间件到达
    public function then(\Closure $destination){
        require_once 'Arguments.php';
        $stack = [];
        $arguments = $this->arguments;
        foreach ($this->handlers as $handler){
            $generator = call_user_func_array($handler,$arguments);
            if($generator instanceof Generator){
                $stack[] = $generator;
                $yieldValue = $generator->current();
                if ($yieldValue === false) {
                    break;
                }elseif($yieldValue instanceof \Arguments){
                    //替换传递参数
                    $arguments = $yieldValue->toArray();
                }
            }
        }
        $result = $destination(...$arguments);
        $isSend = ($result !== null);
        $getReturnValue = version_compare(PHP_VERSION, '7.0.0', '>=');
        //重入函数栈
        while ($generator = array_pop($stack)) {
            /* @var $generator Generator */
            if ($isSend) {
                $generator->send($result);
            }else{
                $generator->next();
            }

            if ($getReturnValue) {
                $result = $generator->getReturn();
                $isSend = ($result !== null);
            }else{
                $isSend = false;
            }
        }
        return $result;
    }

    //根据所有已注册的中间件，获取闭包
    public function getHandlers($middlewares,$module,$controller,$action){
        $middlewares = $this->getSorted($middlewares);
        $befores = [];
        foreach ($middlewares as $key => $val){
            $scope = strtolower($val['scope']);
            if( $scope == 'global'){
                if(strtolower($val['type']) == 'before'){
                    $befores[] = $val['class'];
                }
            }elseif ($scope == 'module'){
                foreach ($val['route'] as $item){
                    $explode = explode('/',$item);
                    if($explode[0] == $module){
                        if(strtolower($val['type']) == 'before'){
                            $befores[] = $val['class'];
                        }
                    }
                }
            }elseif ($scope == 'controller'){
                foreach ($val['route'] as $item){
                    $explode = explode('/',$item);
                    if($explode[0] == $module && $explode[1] == $controller){
                        if(strtolower($val['type']) == 'before'){
                            $befores[] = $val['class'];
                        }
                    }
                }
            }else {
                foreach ($val['route'] as $item){
                    $explode = explode('/',$item);
                    if($explode[0] == $module && $explode[1] == $controller && $explode[2] == $action){
                        if(strtolower($val['type']) == 'before'){
                            $befores[] = $val['class'];
                        }
                    }
                }
            }
        }
        return [
            'before' => $befores,
        ];
    }

    private function getSorted($middlewares){
        $sorts = array_column($middlewares,'sort');
        array_multisort($sorts,SORT_ASC,$middlewares);
        return $middlewares;
    }


//$ben = call_user_func(function (){
//    $hello = (yield 'my name is ben ,what\'s your name'.PHP_EOL);
//    echo $hello;
//});
//
//$sayHello = $ben->current();
//echo $sayHello;   //原文：https://blog.csdn.net/qq_20329253/article/details/52202811
//$ben->send('hi ben ,my name is alex');

//    //注册的中间件组
//    private static $stack = [];
//    //是否执行过中间件
//    private static $hasThroughMiddleware = false;
//    //注册中间件
//    public function register($className='',$action=''){
//
//        $handle = [
//            function($object){
//                $object->hello = 'hello ';
//            },
//            function($object){
//                $object->hello .= 'world';
//            },
//        ];
//
//        $std = new $className();
//        $handle2 = [$std->$action];
//        (new \Middleware())
//            ->send($std)
//            ->through($handle)
//            ->then(function ($object){
//                echo $object->hello;
//            });
//
//
//    }

}