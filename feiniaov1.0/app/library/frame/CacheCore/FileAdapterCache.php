<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 9:27
 */
namespace app\library\frame\CacheCore;

use app\library\frame\CacheCore\secache\secache;

class FileAdapterCache implements ICache
{

    private $path;
    private $file;
    private $cacheObj;

    public function __construct ($groupPath = 'default',$fileName = 'default.txt')
    {
        $this->path = app('config')->get('file_config')['UPLOAD_PATH']."{$groupPath}/";
        $this->file = $this->path.$fileName;
        $this->cacheObj = new secache();
        $this->cacheObj->workat( $this->file );
        // secache本身没有过期时间，所以我们需要往数据里面拼接一个过期时间。
    }

    public function get($key,$default=null){
        $cacheKey = md5($key);
        $res = $this->cacheObj->fetch($cacheKey,$return);
        if(!$res){
            return ['status'=>-1,'msg'=>'获取缓存失败','data'=>$default];
        }
        $cache_data = json_decode($return,true);
        if($cache_data['expire_time'] < time() && $cache_data['expire_time'] !=0){
            //清除缓存
            $this->delete($key);
            return ['status'=>-1,'msg'=>'缓存已过期','data'=>$default];
        }
        return ['status'=>1,'msg'=>'成功','data'=>$cache_data['data']];
    }

    public function pull($key,$default=null){
        $getRes = $this->get($key,$default);
        if($getRes['status'] == 1){
            $this->delete($key);
        }
        return $getRes;
    }

    //$value 只能是string
    // 0标识无过期时间
    public function set($key,$value,$time=0){
        $cacheKey = md5($key);
        $cacheData = json_encode([
            'expire_time' => time() + $time,
            'data' => $value,
        ],JSON_UNESCAPED_UNICODE);
        $res = $this->cacheObj->store($cacheKey,$cacheData);
        return $res?['status'=>1,'msg'=>'成功',]:['status'=>-1,'msg'=>'失败',];
    }

    public function delete($key){
        $cacheKey = md5($key);
        $res = $this->cacheObj->delete($cacheKey);
        return $res?['status'=>1,'msg'=>'成功',]:['status'=>-1,'msg'=>'失败',];
    }

    public function truncate(){
        $res = $this->cacheObj->clear();
        return $res?['status'=>1,'msg'=>'成功',]:['status'=>-1,'msg'=>'失败',];
    }


}