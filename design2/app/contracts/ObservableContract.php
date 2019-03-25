<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 14:27
 */
namespace app\contracts;

/**
 * --接口契约--被观察者组
 * 继承该接口的实体 应该去维护观察组的添加和删除
 */

interface ObservableContract{

    function addObserver( $observer );

    function removeObserver( $observerName );

}