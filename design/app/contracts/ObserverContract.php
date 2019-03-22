<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 15:07
 */
namespace app\contracts;

/**
 * --接口契约--被观察者组
 */

interface ObserverContract{
    /**
     * 监听接受的消息
     * @return mixed
     */
    function onSendMsg( $sender, $args );

    /**
     * 本观察者对象的名称
     * @return mixed
     */
    function getName();

}