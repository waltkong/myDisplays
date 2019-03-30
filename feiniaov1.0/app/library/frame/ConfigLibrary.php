<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/25
 * Time: 11:54
 */

namespace app\library\frame;

/**
 * 配置库
 * 【减少对底层的文件的调用，降低耦合。】
 */
class ConfigLibrary{

    public function get($key,$default=''){
        $obj = \Config::getInstance();
        return $obj->get($key,$default);
    }

    public function set($key,$value){
        $obj = \Config::getInstance();
        $obj->set($key,$value);
    }

    public function delete($key){
        $obj = \Config::getInstance();
        $obj->delete($key);
    }

    public function getAll(){
        $obj = \Config::getInstance();
        return $obj->settings;
    }

}