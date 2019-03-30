<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 9:15
 */

namespace app\library\frame\CacheCore;

interface ICache
{

    public function get($key);    //获取缓存

    public function pull($key);    //一次性获取缓存

    public function set($key,$value,$time);    //设置缓存

    public function delete($key);     //删除缓存

    public function truncate();     //清空缓存


}