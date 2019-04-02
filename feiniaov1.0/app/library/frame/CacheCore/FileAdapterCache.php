<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 9:27
 */
namespace app\library\frame\CacheCore;

use app\library\frame\CacheCore\CFileCache\CFileCache;


class FileAdapterCache implements ICache
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
        $this->cacheObj = new CFileCache($this->file);
    }

    public function get($key,$default=null){
        $res = $this->cacheObj->get($key);
        return $res;
    }

    public function pull($key,$default=null){
        $getRes = $this->get($key,$default);
        if($getRes){
            $this->delete($key);
        }
        return $getRes;
    }

    public function set($key,$value,$time=0){
        if(!is_string($value) && !is_numeric($value)){
            throw new \Exception('string only');
        }
        $expire_time = empty($time)? time()+3600*24*30*12 : time()+$time;
        $res = $this->cacheObj->set($key,$value,$expire_time);
        return $res;
    }

    public function delete($key){
        $res = $this->cacheObj->del($key);
        return $res;
    }

    public function truncate(){
        $res = del_files($this->path);
        return $res;
    }


}