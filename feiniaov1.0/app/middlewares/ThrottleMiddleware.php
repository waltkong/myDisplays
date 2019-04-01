<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/31
 * Time: 20:26
 */

namespace app\middlewares;

use app\library\contracts\IMiddleware;
use Closure;

class ThrottleMiddleware implements IMiddleware
{

    /**
     * @param $request
     * @return Closure
     */
    public function handle($request){
        return function () use($request){
            $frequency = 2;   // 频率限定 2次/min

            $clientIp = app('request')->clientIp();
            $minTime = date('YmdHi');
            $cache = app('cache')->get("clientIp_frequency_".$clientIp,'');
            $cache = empty($cache)?[]:json_decode($cache,true);
            if(isset($cache['count']) && $cache['count'] > $frequency){
                echo "频率太快";die;
            }else{
                $cacheData = [
                    'time' => $minTime,
                    'count' =>  empty($cache) ? 1: $cache['count']++,
                ];
                app('cache')->set("clientIp_frequency_".$clientIp,json_encode($cacheData),120);
            }
        };
    }

}