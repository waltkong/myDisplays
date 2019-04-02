<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/31
 * Time: 20:09
 */

namespace app\controllers\admin;



use app\library\frame\CacheCore\FileAdapterCache;

class IndexController
{
    public function index(){
        $a = 1;
        $b=2;
        $obj = new FileAdapterCache('ooo');
        $get0 =  $obj->get('aaab');
        echo $get0.'--';
        $obj->set('aaab',11);
        $get1 =  $obj->get('aaab');
        echo $get1.'--';
        return app('response')->view('welcome');
    }

}



