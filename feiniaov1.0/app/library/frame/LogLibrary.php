<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/27
 * Time: 14:36
 */
namespace app\library\frame;

class LogLibrary
{

    /**
     * 打印一般信息
     * @param $data
     * @param string $description
     */
    public function info( $data, $description=''){
        $obj = new \Log();
        $obj->info($data,$description);
    }

    /**
     * 打印错误信息
     * @param $data
     * @param string $description
     */
    public function error( $data, $description=''){
        $obj = new \Log();
        $obj->error($data,$description);
    }


}