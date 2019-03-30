<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 16:28
 */

namespace app\library\frame;

use app\library\frame\FileCore\MFile;

class FileLibrary
{

    /**
     * 上传
     * @param string $group
     * @param int $maxsize
     * @param array $allowExt
     * @return array
     */
    public function upload( $group='default', $maxsize=10485760, $allowExt=array('jpeg','jpg','png','txt','xlsx','xls','csv')){
        $fileinfo = $_FILES['file'];
        $obj = new MFile();
        $obj->maxsize = $maxsize;
        $obj->allowExt = $allowExt;
        $res = $obj->upload($fileinfo,$group);
        return $res;
    }

    /**
     * 下载
     * @param $fileName
     * @return bool
     */
    public function download( $fileName){
        $obj = new MFile();
        $res = $obj->download($fileName);
        return $res;
    }
}