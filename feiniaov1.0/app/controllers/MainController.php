<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 15:19
 */
namespace app\controllers;

use app\library\frame\ConfigLibrary;
use app\services\DesignService;

class MainController{


    private $config;
    public function __construct ()
    {
        $this->config = new ConfigLibrary();
    }

    /*
     * 访问方式  http://local.design.com/index.php?url=Main/test
     *
     */
    public function test(){
        $obj = new DesignService();
//        $obj->observer();
        //$obj->decorator();
       // $obj->proxy();
        //$obj->strategy();

        $configs =  $this->config->getAll();
        $db_config = $this->config->get('db_config');
        var_dump($db_config) ;
    }




}