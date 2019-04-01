<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/31
 * Time: 20:09
 */

namespace app\controllers\admin;

class IndexController
{
    public function index(){
        $a = 1;
        $b=2;

        $mid = app('request')->a;


        return app('response')->view('welcome');
    }

}



