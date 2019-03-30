<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/29
 * Time: 10:04
 */
namespace app\library\frame;

/**
 * 请求类
 */
class RequestLibrary
{
    private static $has_init = false;

    private static $raw;

    private static $request;

    private static $url;

    public function __construct (){
        if(!self::$has_init){
            $guard = app('guard');    //xss防护
            self::$raw = file_get_contents("php://input");
            $reqs = $_REQUEST;
            $new_request = [];
            foreach ($reqs as $k => $req){
                if($k == 'url'){
                    self::$url = $req;
                }else{
                    $new_request[$k] = $guard->RemoveXSS($req);
                }
            }
            self::$request = $new_request;
            self::$has_init = true;
        }
    }
    public function all(){
        return self::$request;
    }
    public function get($param,$default=''){
        return isset(self::$request[$param])?self::$request[$param]:$default;
    }
    public function raw(){
        return self::$raw;
    }
    public function host(){
        return $_SERVER['HTTP_HOST'];   //获取当前域名
    }
    public function method(){   //get  post
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function clientIp(){
        return $_SERVER['REMOTE_ADDR'];
    }
    public function serverIp(){
        return $_SERVER['SERVER_ADDR'];
    }
    public function httpProtocol(){
        return strtolower($_SERVER['REQUEST_SCHEME']);
    }
    public function getCookie(){
        return $_SERVER['HTTP_COOKIE'];
    }

}