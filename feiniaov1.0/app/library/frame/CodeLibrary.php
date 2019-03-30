<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/29
 * Time: 11:54
 */

namespace app\library\frame;

use app\library\frame\CodeCore\VerifyCode;

Class CodeLibrary
{
    public $codeString;

    public $codeObj;

    /**
     * 获取验证码字符串
     * @param int $w
     * @param int $h
     * @param int $n
     * @param string $imageType
     * @param int $codeType
     * @return bool|string
     */
    public function getCode( $w=100, $h=50, $n=4, $imageType='png', $codeType=1){
        $this->codeObj = new VerifyCode();
        $this->codeString = $this->codeObj->createCode($this->codeObj->codeType);
        return $this->codeString;
    }

    /**
     * 获取字符串后，将字符串保存到session或者token后，再显示图片给用户
     */
    public function showCode(){
        $this->codeObj->show();
    }

}
