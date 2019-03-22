<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 15:07
 */
namespace app\contracts;

/**
 * --接口契约--
 * 定义 实体对象 和 代理对象 共有的行为
 *
 *     * 给某一个对象提供一个代理，并由代理对象控制对原对象的引用
 * 代理模式包含如下角色：
　　抽象主题角色（Subject）：定义了RealSubject和Proxy公用接口，这样就在任何使用RealSubject的地方都可以使用Proxy。
　　真正主题角色（RealSubject）：定义了Proxy所代表的真实实体。
　　代理对象（Proxy）：保存一个引用使得代理可以访问实体，并提供一个与RealSubject接口相同的接口，这样代理可以用来代替实体(RealSubject)。
 *
 */

interface NetworkProxyContract
{

    public function connect();

    public function visitWebsite();


}