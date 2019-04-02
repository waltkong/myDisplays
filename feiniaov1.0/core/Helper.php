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


if(!function_exists('make_dir')){
    function make_dir($dir){
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
    }
}

if(!function_exists('del_files')){
    function del_files($dirName){
        if(file_exists($dirName) && $handle=opendir($dirName)){
            while(false!==($item = readdir($handle))){
                if($item!= "." && $item != ".."){
                    if(file_exists($dirName.'/'.$item) && is_dir($dirName.'/'.$item)){
                        del_files($dirName.'/'.$item);
                    }else{
                        if(unlink($dirName.'/'.$item)){
                            return true;
                        }
                    }
                }
            }
            closedir( $handle);
        }
    }
}

