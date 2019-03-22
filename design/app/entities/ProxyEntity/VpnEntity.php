<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 15:45
 */
namespace app\entities\ProxyEntity;

use app\contracts\NetworkProxyContract;

class VpnEntity implements NetworkProxyContract
{
    private $userName;

    public function __construct ($userName)
    {
        $this->userName = $userName;
    }

    public function connect ()
    {
        echo "{$this->userName } 正在连接网络。。。"."<br>";
    }

    public function visitWebsite ()
    {
        echo "{$this->userName } 正在浏览网页。。。"."<br>";
    }

}