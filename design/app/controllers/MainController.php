<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 15:19
 */
namespace app\controllers;

use app\services\DesignService;

class MainController{


    /*
     * 访问方式  http://local.design.com/index.php?url=Main/test
     *
     */
    public function test(){
        $obj = new DesignService();
//        $obj->observer();
        //$obj->decorator();
       // $obj->proxy();
        $obj->strategy();
    }



}