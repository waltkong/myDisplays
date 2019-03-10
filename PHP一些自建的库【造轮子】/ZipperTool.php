<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/1/23
 * Time: 9:32
 */
namespace App\Library\Tools;

use Chumper\Zipper\Facades\Zipper;

/**
     *
     *  vendor "chumper/zipper": "1.0.x"
 * */
class ZipperTool
{

    /**
     * 将 $folder 目录下的文件全部打包压缩
     * @param $folder
     * @return mixed 返回打包后的文件全路径
     */
    public function zip( $folder){
        $files = glob($folder.'*');    //$folder='public/files/*'

        $zipFullName = storage_path('app/public/zip/').date('YmdHis').rand(1000,9999).'.zip';

        Zipper::make($zipFullName)->add($files)->close();

        return $zipFullName;
    }



}