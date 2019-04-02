<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 9:27
 */
namespace app\library\frame\CacheCore;

use app\library\frame\CacheCore\secache\secache;

class FileAdapterCache_bak implements ICache
{

    private $path;
    private $file;
    private $cacheObj;

    public function __construct ($prefix = 'default')
    {
        $prefix = 'file_'.$prefix;
        $this->path = app('config')->get('file_config')['CACHE_PATH']."{$prefix}/";
        make_dir($this->path);
        $this->file = $this->path.$prefix;
        $this->cacheObj = new secache();
        $this->cacheObj->workat( $this->file );
        // secache本身没有过期时间，所以我们需要往数据里面拼接一个过期时间。
    }

    public function get($key,$default=null){
        $cacheKey = md5($key);
        $res = $this->cacheObj->fetch($cacheKey,$return);
        if(!$res){
            return $default;
        }
        $cache_data = json_decode($return,true);
        if($cache_data['expire_time'] < time() && $cache_data['expire_time'] !=0){
            //清除缓存
            $this->delete($key);   //缓存已过期
            return false;
        }
        return $cache_data['data'];
    }

    public function pull($key,$default=null){
        $getRes = $this->get($key,$default);
        if($getRes){
            $this->delete($key);
        }
        return $getRes;
    }

    //$value 只能是string
    // 0标识无过期时间
    public function set($key,$value,$time=0){
        $cacheKey = md5($key);
        $expire_time = $time==0?0:time() + $time;
        $cacheData = json_encode([
            'expire_time' => $expire_time,
            'data' => $value,
        ],JSON_UNESCAPED_UNICODE);
        $res = $this->cacheObj->store($cacheKey,$cacheData);
        return $res;
    }

    public function delete($key){
        $cacheKey = md5($key);
        $res = $this->cacheObj->delete($cacheKey);
        return $res;
    }

    public function truncate(){
        $res = $this->cacheObj->clear();
        return $res;
    }


}