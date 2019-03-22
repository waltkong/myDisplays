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
        $this->_auto_load();
        $this->_route();
    }

    // 自动加载命名空间
    private function _auto_load(){
        include 'Loader.php';
        spl_autoload_register('Loader::autoload');
    }

    // 路由处理
    private function _route(){
        $controllerName = 'Index';
        $action = 'index';
        if (!empty($_GET['url'])) {
            $url = $_GET['url'];
            $urlArray = explode('/', $url);
            // 获取控制器名
            $controllerName = ucfirst($urlArray[0]);
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
        $controller = "app\controllers\\".$controllerName . 'Controller';
        $dispatch = new $controller($controllerName, $action);
        // 如果控制器存和动作存在，这调用并传入URL参数
        if ((int)method_exists($controller, $action)) {
            call_user_func_array(array($dispatch, $action), $queryString);
        } else {
            exit($controller . "控制器不存在");
        }
    }


}