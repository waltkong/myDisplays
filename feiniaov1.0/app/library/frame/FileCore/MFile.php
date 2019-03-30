<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 17:08
 */

namespace app\library\frame\FileCore;
class MFile
{

    public $maxsize = 10485760;  //10M,10*1024*1024
    public $allowExt = array('jpeg','jpg','png','txt','xlsx','xls','csv');//允许上传的文件类型（拓展名)

    public function upload($fileinfo,$group='default'){   //$fileinfo = $_FILES['file']
        try{
            $this->check($fileinfo);
            $filename = date('H:i:s',time()).'_'.rand(100000,999999);
            $fileConfigPath = app('config')->get('file_config')['UPLOAD_PATH'];
            $filePath = $fileConfigPath."{$group}".'/'.date('Y').'/'.date('m').'/'.date('d').'/';
            if(!is_dir($filePath)){
                mkdir($filePath,0777,true);
            }
            $fileFullName = $filePath.$filename;
            move_uploaded_file($fileinfo["tmp_name"],$fileFullName);
            return ['status'=> 1, 'msg' => '上传操作成功','fileName'=>$fileFullName];
        }catch (\Exception $e){
            return ['status'=> -1, 'msg' => $e->getMessage()];
        }
    }

    public function check($fileinfo){
        if($fileinfo['error'] != 0){
            throw new \Exception('文件上传出错');
        }
        if($fileinfo['size'] > $this->maxsize){
            throw new \Exception("文件太大");
        }
        $ext = pathinfo($fileinfo['name'],PATHINFO_EXTENSION);
        if(!in_array($ext,$this->allowExt)){
            throw new \Exception("文件上传类型不允许");
        }
        if(!is_uploaded_file($fileinfo["tmp_name"])){
            throw new \Exception("上传方式有误，请用post");
        }
    }

    public function download($fileName){
        if(!file_exists($fileName)){
            return false;
        }
        $fp=fopen($fileName,"r");
        $file_size=filesize($fileName);
        //下载文件需要用到的头
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".$fileName);
        $buffer=10240000;
        $file_count=0;
        //向浏览器返回数据
        while(!feof($fp) && $file_count<$file_size){
            $file_con=fread($fp,$buffer);
            $file_count+=$buffer;
            echo $file_con;
        }
        fclose($fp);
    }

}