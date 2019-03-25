<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/25
 * Time: 11:37
 */

/**
 * 框架主控制器
 */
class Controller
{

    public function __construct (){}

    /**
     * 加载视图模板,纯html文件，不需要向模板传递数据
     * @param $path
     */
    public function view( $path){
        $view = new \View();
        $path =  $view->parse($path);
        echo file_get_contents($path);
        return true;
    }




}