<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/1/22
 * Time: 14:57
 */
class BaseController extends Controller
{

    public function __construct ( $controller, $action )
    {
        $this->_initialize();
        $this->auth();
        parent::__construct($controller, $action);
    }

    /**
     * 供继承的构造方法
     */
    protected function _initialize(){

    }

    /**
     * 权限认证
     */
    protected function auth(){

    }

}