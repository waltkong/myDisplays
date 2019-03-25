<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/25
 * Time: 11:17
 */

if(!function_exists('storage_path')){
    function storage_path($fileDir){
        return BASE_PATH.'storage/'.$fileDir;
    }
}

