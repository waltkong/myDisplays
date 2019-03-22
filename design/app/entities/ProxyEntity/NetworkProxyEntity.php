<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 15:46
 */
namespace app\entities\ProxyEntity;

use app\contracts\NetworkProxyContract;

class NetworkProxyEntity implements NetworkProxyContract
{

    //这个网络代理本身无法访问网，需要靠vpn来实现联网和访问网页

    private $vpn =null;


    public function __construct (VpnEntity $vpnEntity = null)
    {
        $this->vpn = $vpnEntity;
    }

    public function connect ()
    {
        //代理层可以做用户过滤

        $this->vpn->connect();
    }

    public function visitWebsite ()
    {
        $this->vpn->visitWebsite();
    }


}