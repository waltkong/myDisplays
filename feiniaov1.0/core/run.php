<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 16:00
 */

include 'Feiniao.php';


define('__STATIC__',BASE_PATH.'static/');     // 静态资源目录
define('__VIEW__',BASE_PATH.'view/');     // 模板视图目录

$core = new Feiniao();
$core->run();
