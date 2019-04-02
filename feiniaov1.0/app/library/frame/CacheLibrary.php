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


    public $prefix = 'default';

    public static $instances = [];

    public function __construct (){}

    public function get($key,$default=''){
        return $this->getCacheAdapter()->get($key,$default);
    }

    public function pull($key,$default=''){
        return $this->getCacheAdapter()->pull($key,$default);
    }

    public function set($key,$value,$time=3600*24){
        return $this->getCacheAdapter()->set($key,$value,$time);
    }

    public function delete($key){
        return $this->getCacheAdapter()->delete($key);
    }

    public function truncate(){
        return $this->getCacheAdapter()->truncate();
    }

    public function prefix($prefix){
        $this->prefix = $prefix ;
        return $this;
    }

    private function getCacheAdapter(){
        if(!isset(self::$instances[$this->prefix])){
            $cacheDriver = app('config')->get('driver_config')['CACHE_DRIVER'];
            switch (strtolower($cacheDriver)){
                case 'redis':
                    $cacheObj = new RedisAdapterCache($this->prefix);
                    break;
                default:   // 'file'
                    $cacheObj = new FileAdapterCache($this->prefix);
                    break;
            }
            self::$instances[$this->prefix] = $cacheObj;
        }
        return self::$instances[$this->prefix];
    }

}
