<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/25
 * Time: 11:14
 */

$db_config = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'fisher',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => 'root',
    'DB_CHARSET' => 'utf8',
    'DB_PREFIX' => '',
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
