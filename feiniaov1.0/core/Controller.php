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

    public function __construct ()
    {
        $this->beforeMiddleware();
        $this->_init();
    }

    public function beforeMiddleware()
    {

    }

    protected function _init()
    {

    }

    public function __destruct()
    {
       $this->afterMiddleware();
    }

    public function afterMiddleware()
    {

    }

}