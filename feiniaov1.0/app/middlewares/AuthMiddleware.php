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

class AuthMiddleware implements IMiddleware
{


    /**
     * @param $request
     * @return \Closure
     */
    public function handle($request){
        return function () use($request){
            $request->a = 1;
            $a =  'ggg';
            $b =  'bbb';
        };
    }
}

