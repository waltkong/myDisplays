<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/28
 * Time: 17:39
 */


//备份框架的所有配置文件

$debug_config = true;

$db_config = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'fast_mvc',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => 'root',
    'DB_CHARSET' => 'utf8',
    'DB_PREFIX' => 'llb_',
];

$driver_config = [
    'CACHE_DRIVER' => 'file',    // 可选值 file 和 redis
    'SESSION_DRIVER' => 'file',    //可选值 file 和 redis
];

$file_config = [
    'CACHE_PATH' => storage_path('cache/'),
    'SESSION_PATH' => storage_path('session/'),
    'UPLOAD_PATH' => storage_path('upload/'),
    'LOG_PATH' => storage_path('log/'),
    'DOWNLOAD_PATH' => storage_path('download/'),
];

$redis_config = [
    'REDIS_HOST' => '127.0.0.1',
    'REDIS_PASSWORD' => null,
    'REDIS_PORT' => '6379',
];