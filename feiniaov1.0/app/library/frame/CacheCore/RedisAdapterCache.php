<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 9:27
 */
namespace app\library\frame\CacheCore;

use app\library\frame\RedisCore\RedisCluster;

class RedisAdapterCache implements ICache
{

    private $redis;
    private $redis_prefix = '';

    public function __construct ($prefix)
    {
        $redis_config = app('config')->get('redis_config');
        $redis_option = [
            'REDIS_HOST' => isset($redis_config['REDIS_HOST'])?$redis_config['REDIS_HOST']:'127.0.0.1',
            'REDIS_PASSWORD' => isset($redis_config['REDIS_PASSWORD'])?$redis_config['REDIS_PASSWORD']:null,
            'REDIS_PORT' => isset($redis_config['REDIS_PORT'])?$redis_config['REDIS_PORT']:'6379',
        ];
        $this->redis = new RedisCluster();
        $this->redis->connect(array('host'=>$redis_option['REDIS_HOST'],'port'=>$redis_option['REDIS_PORT']));
        $this->redis_prefix = 'redis_'.$prefix;
    }

    public function get($key,$default=''){
        $cacheKey =  $this->redis_prefix.$key;
        $value = $this->redis->get($cacheKey);
        return $value;
    }

    public function pull($key,$default=''){
        $getRes = $this->get($key,$default);
        if($getRes){
            $this->delete($key);
        }
        return $getRes;
    }

    public function set($key,$value,$time=0){   //0代表永久
        $cacheKey =  $this->redis_prefix.$key;
        $this->redis->set($cacheKey,$value,$time);
        return true;
    }

    public function delete($key){
        $cacheKey =  $this->redis_prefix.$key;
        $intNum = $this->redis->remove($cacheKey);
        return $intNum;
    }

    public function truncate(){
        $this->redis->clear();
        return true;
    }

}