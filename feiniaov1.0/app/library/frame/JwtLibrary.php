<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/27
 * Time: 11:50
 */
namespace app\library\frame;
use app\library\frame\JwtCore\JWT;
class JwtLibrary
{
    public $refreshToken;
    public $key = 'abc123';
    public $time;
    public $iss = 'feiniao';   //签发者 可选
    public $aud = 'feiniao';   //接受者 可选
    public $expire_time;
    public $refresh_time;

    public function __construct (){
        $this->expire_time = 3600*24; //过期时间,这里默认设置一天吧
        $this->refresh_time = 3600;   //刷新时间 比如 1小时
    }
    /**
     *签发token
     *
     */
    public function issue(array $data=[]){
        $data['refresh_time'] = $this->time + $this->refresh_time;
        $token = [
            'iss' => $this->iss, //签发者 可选
            'aud' => $this->aud, //接收该JWT的一方，可选  'http://www.helloweba.net'
            'iat' => $this->time, //签发时间
            'nbf' => $this->time + 1 , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $this->time+$this->expire_time,
            'data' => $data,
        ];
        $jwt = JWT::encode($token,$this->key,$alg = 'HS256');
        return $jwt;
    }
    /**
     *验证token
     */
    public function verification($jwt){
        try {
            JWT::$leeway = 1;//当前时间减去1，把时间留点余地
            $decoded = JWT::decode($jwt, $this->key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            $data = $arr['data'];
            if(!empty($data) && !is_array($data)){
                if(is_object($data)){
                    $data = json_encode($data,JSON_UNESCAPED_UNICODE);
                }
                $data = json_decode($data,1);
                if($data['refresh_time'] < time()){  //就必须得刷新了
                    $this->refreshToken = $this->issue($data);
                }
            }
            return [
                'status' => 1,
                'data' => $data,
            ];
        } catch(\Exception $e) {  //其他错误
            return [
                'status' => -1,
                'msg' =>$e->getMessage(),
            ];
        }
    }

    /**
     *获取刷新后的token
     * 接收原token
     * 结果返回给前台
     */
    public function getRefreshToken($jwt){
        if(!empty($this->refreshToken)){
            return $this->refreshToken;
        }else{
            return $jwt;
        }
    }

}