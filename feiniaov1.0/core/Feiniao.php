<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 16:00
 */
class Feiniao
{
    // 运行程序
    public function run(){
        $this->_include_core_file();
        $this->_auto_load();    //自动加载要在第一步

        $this->_route();
    }

    // 自动加载命名空间
    private function _auto_load(){
        require_once 'Loader.php';
        spl_autoload_register('Loader::autoload');
    }

    //引入核心文件
    private function _include_core_file(){
        require_once 'Helper.php';
        require_once 'Config.php';
        require_once 'Database.php';
        require_once 'Model.php';
        require_once 'Controller.php';
        require_once 'View.php';
        require_once 'Log.php';
        require_once 'Middleware.php';
    }

    // 路由处理
    private function _route(){
        $moduleName = 'admin';
        $controllerName = 'Index';
        $action = 'index';
        if (!empty($_GET['url'])) {
            $url = $_GET['url'];
            $urlArray = explode('/', $url);
            //获取模块名
            $moduleName = empty($urlArray[0])? 'admin':strtolower($urlArray[0]);
            // 获取控制器名
            array_shift($urlArray);
            $controllerName = empty($urlArray[0])?"Index": ucfirst($urlArray[0]);
            // 获取动作名
            array_shift($urlArray);
            $action = empty($urlArray[0]) ? 'index' : $urlArray[0];
            //获取URL参数
            array_shift($urlArray);
            $queryString = empty($urlArray) ? array() : $urlArray;
        }
        // 数据为空的处理
        $queryString  = empty($queryString) ? array() : $queryString;
        // 实例化控制器
        $controller = "app\controllers\\".$moduleName."\\".$controllerName . 'Controller';

        $this->beforeController($controller,$moduleName,$controllerName,$action,$queryString);

        $this->handleController($controller,$moduleName,$controllerName,$action,$queryString);

    }

    private function beforeController($controller,$moduleName,$controllerName,$action,$queryString){
        $registered_middleware = (new \app\Kernel()) ->middleware;
        $middlewareCoreObj = new \Middleware();
        $handleClass = $middlewareCoreObj->getHandlers($registered_middleware,$moduleName,$controllerName,$action);

        $dealController = new $controller();
        $dealBefores = $handleClass['before'];

        $through = [];
        $request = app('request');
        foreach ($dealBefores as $dealBefore){
            $through[] = (new $dealBefore)->handle($request);
        }
        $chain = $middlewareCoreObj->send($dealController);
        $chain = $chain->through($through);
        $chain->then(function ($object){
            $a = 11111;
                //do something ..
            });
    }

    private function handleController($controller,$moduleName,$controllerName,$action,$queryString){
        $dispatch = new $controller($controllerName, $action);
        // 如果控制器存和动作存在，这调用并传入URL参数
        if ((int)method_exists($controller, $action)) {
            call_user_func_array(array($dispatch, $action), $queryString);
        } else {
            exit($controller . "控制器不存在");
        }
    }



}