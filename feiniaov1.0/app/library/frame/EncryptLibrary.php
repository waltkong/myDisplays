<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 16:00
 */

namespace app\library\frame;

use app\library\frame\EncryptCore\Mcrypt;

class EncryptLibrary
{

    /**
     * 加密
     * @param $string
     * @param string $key    加盐
     * @return string
     */
    public function encrypt( $string, $key = ''){
        $obj = new Mcrypt();
        $result = $obj->encode($string,$key, $expiry=0);
        return $result;
    }

    /**
     * 解密
     * @param $string
     * @param string $key    加盐
     * @return string
     */
    public function decrypt( $string, $key = ''){
        $obj = new Mcrypt();
        $result = $obj->decode($string,$key);
        return $result;
    }


}