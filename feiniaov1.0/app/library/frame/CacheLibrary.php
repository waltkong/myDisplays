<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 9:15
 */
namespace app\library\frame;

use app\library\frame\CacheCore\FileAdapterCache;
use app\library\frame\CacheCore\RedisAdapterCache;

class CacheLibrary{

    public static $instance;

    public function __construct (){}

    public function get($key){
        return self::getInstance()->get($key);
    }

    public function pull($key){
        return self::getInstance()->pull($key);
    }

    public function set($key,$value,$time=3600*24){
        return self::getInstance()->set($key,$value,$time);
    }

    public function delete($key){
        return self::getInstance()->delete($key);
    }

    public function truncate(){
        return self::getInstance()->truncate();
    }

    public static function getInstance($groupPath='',$fileName=''){
        if(!self::$instance){
            self::$instance = self::getCacheAdapter($groupPath,$fileName);
        }
        return self::$instance;
    }

    private static function getCacheAdapter($groupPath='',$fileName=''){
        $cacheDriver = app('config')->get('driver_config')['CACHE_DRIVER'];
        switch (strtolower($cacheDriver)){
            case 'redis':
                $cacheObj = new RedisAdapterCache($groupPath,$fileName);
                break;
            default:   // 'file'
                $cacheObj = new FileAdapterCache($groupPath,$fileName);
                break;
        }
        return $cacheObj;
    }

}
