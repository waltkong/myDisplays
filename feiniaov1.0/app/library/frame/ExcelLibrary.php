<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 16:29
 */

namespace app\library\frame;

use app\library\ExcelCore\MExcel;

class ExcelLibrary
{

    /**
     * 导入
     * @param $file  excel文件路径
     * @param int $sheet  excel的页码
     */
    public function import( $file, $sheet=0){
        $obj = new MExcel();
        $obj->importExecl($file, $sheet=0); // TODO
    }

    /**
     * 导出
     * @param array $title   标题行名称
     * @param array $data    导出数据
     * @param string $fileName   文件名
     * @param string $savePath    保存路径
     * @param bool $isDown     是否下载  false--保存   true--下载
     */
    public function export( $title=array(), $data=array(), $fileName='', $savePath='default', $isDown=true){
        $downPath = app('config')->get('file_config')['DOWNLOAD_PATH'];
        $savePath = $downPath.$savePath.'/';
        $obj = new MExcel();
        $saveFile = $obj->exportExcel($title, $data, $fileName, $savePath, $isDown);
        return $saveFile;
    }


}
