<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 16:28
 */

namespace app\library\frame;

/**
 * 表单类
 */
class FormLibrary
{
    /**
     * 邮箱验证
     * @param $email
     * @return false|int
     */
    public function checkEmail( $email){
        //正则
        $reg='/^\w+@\w+[.]com|cn|net$/';
        return preg_match($reg,$email);
    }
    /**
     * 验证身份证
     * @param $card
     * @return false|int
     */
    public function checkCard( $card){
        //正则
        $reg='/^(\d{18}|\d{17}x)$/';
        return preg_match($reg,$card);
    }
    /**
     * 检测url地址是否正确
     * @param $website
     * @return bool
     */
    public function checkUrl( $website){
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
            return false;
        }
        return true;
    }
    /**
     * 检测名字是否正常 //只允许字母和空格
     * @param $name
     * @return bool
     */
    public function checkName( $name){
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            return false;
        }
        return true;
    }
    /**
     * 手机验证
     * @param $mobile
     * @return bool
     */
    public function checkMobile( $mobile){
        if(!preg_match("/^1[345678]{1}\d{9}$/",$mobile)){
            return false;
        }
        return true;
    }

}

