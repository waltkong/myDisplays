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
            $frequency = app('config')->get('api_frequency_config',60);   // 频率限定 多少次/min
            $clientIp = app('request')->clientIp();
            $cache = app('cache')->prefix('clientIp_frequency')->get($clientIp,1);
            if(!empty($cache) && $cache > $frequency ){
                return app('response')->json('频率太快');
            }else{
                $data = empty($cache) ? 1: $cache+1 ;
                app('cache')->prefix('clientIp_frequency')->set($clientIp,$data,60);
            }
        };
    }

}