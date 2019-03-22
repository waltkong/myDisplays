<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 15:01
 */
namespace app\contracts;

/**
 * --接口契约
 *  装饰器
 */
interface DecoratorContract
{
    public function before();   //前置操作

    public function after();    //后置操作

}