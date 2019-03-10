<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/1/22
 * Time: 13:44
 */

// 应用目录为当前目录
define('APP_PATH', __DIR__.'/');

// 开启调试模式
define('APP_DEBUG', true);

// 网站根URL
define('APP_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']);

define('APP_HOST', $_SERVER['HTTP_HOST']);

// 加载框架
require './fastphp/fastphp.php';