<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/27
 * Time: 13:39
 */

namespace app\library\frame;

/**
 * 接口返回类
 */
class ApiLibrary
{
    //增加一个token
    public static $token;
    //测试返回值
    public static $debug;
    /**
     * 成功
     * @var string
     */
    const RETURN_SUCCESS = "0001";
    /**
     * 错误
     * @var string
     */
    const RETURN_ERROR = "0002";
    /**
     * 身份校验失败
     * @var string
     */
    const RETURN_VERIFY_ERROR = "0003";

    public function returnJSON($code, $msg, $data = array(), $end = true)
    {
        $return_data = array(
            'status' => ($code != self::RETURN_SUCCESS) ? 'false' : 'true',
            'code'   => (string)$code,
            'msg'    => $msg,
            'data'   => $data,
            'time'     => (string)time(),
            'token'  => self::$token,
            'debug'  => self::$debug,
        );
        return $return_data;
    }

    public function error($msg, $end = true)
    {
        return self::returnJSON(self::RETURN_ERROR, $msg, array(), $end);
    }

    public function success($data = array(), $msg = '成功', $end = true)
    {
        return self::returnJSON(self::RETURN_SUCCESS, $msg, $data, $end);
    }

    public function verifyError($msg, $end = true)
    {
        return self::returnJSON(self::RETURN_VERIFY_ERROR, $msg, array(), $end);
    }

}
