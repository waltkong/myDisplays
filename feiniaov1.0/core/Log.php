<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/27
 * Time: 13:50
 */

class Log
{
    public function info($data,$description=''){
        $errorMode = 'Info';
        self::addData($errorMode,$data,$description);
    }

    public function error($data,$description=''){
        $errorMode = 'Error';
        self::addData($errorMode,$data,$description);
    }

    private function addData($errorMode,$data,$description=''){
        $logPath = Config::getInstance()->get('file_config')['LOG_PATH'].date('Y',time()).'/'.date('m',time()).'/'.date('d',time()).'/';
        if(!is_dir($logPath)){
            mkdir($logPath,0777,true);
        }
        $fileName = date('Y-m-d',time()).'-'.$description.'.txt';
        $file = $logPath.$fileName;
        if(is_array($data)){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $content = "[{$errorMode}] ".'-Date-Time-'.date('Y-m-d H:i:s',time()).'-'.$data."\r\n";
        file_put_contents($file,$content,FILE_APPEND);
    }


}