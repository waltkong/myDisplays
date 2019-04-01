<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/4/1
 * Time: 21:26
 */

namespace app\library\contracts;

interface IMiddleware
{
    public function handle($request);
}