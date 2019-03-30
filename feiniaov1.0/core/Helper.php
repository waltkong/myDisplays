<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/25
 * Time: 11:17
 */


require_once BASE_PATH.'app/common/helper.php';

if(!function_exists('storage_path')){
    function storage_path($fileDir){
        return BASE_PATH.'storage/'.$fileDir;
    }
}

if(!function_exists('json_response')){
    function json_response($data){
        if(is_array($data)){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        echo $data;exit();
    }
}

if(!function_exists('app')){
    function app($data){
        return \app\library\frame\AppFactoryLibrary::getInstance($data);
    }
}

