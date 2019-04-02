<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/27
 * Time: 14:38
 */
namespace app\library\frame;


/**
 * 核心工厂
 */
class AppFactoryLibrary{

    // 保存已经实例过的对象
    private static $instances = [];


    /**
     * @param $data
     * @return ApiLibrary|CacheLibrary|ConfigLibrary|CurlLibrary|JwtLibrary|LogLibrary|mixed|null
     */
    public static function getInstance($data){
        $key = strtolower($data);
        if(!isset(self::$instances[$key])){
            $obj = null;
            switch ($key){
                case 'log':
                    $obj =  new LogLibrary();
                    break;
                case 'api':
                    $obj =  new ApiLibrary();
                    break;
                case 'curl':
                    $obj =  new CurlLibrary();
                    break;
                case 'config':
                    $obj =  new ConfigLibrary();
                    break;
                case 'jwt':
                    $obj =  new JwtLibrary();
                    break;
                case 'cache':
                    $obj =  new CacheLibrary();
                    break;
                case 'encrypt':
                    $obj =  new EncryptLibrary();
                    break;
                case 'excel':
                    $obj =  new ExcelLibrary();
                    break;
                case 'file':
                    $obj =  new FileLibrary();
                    break;
                case 'form':
                    $obj =  new FormLibrary();
                    break;
                case 'request':
                    $obj =  new RequestLibrary();
                    break;
                case 'guard':
                    $obj =  new GuardLibrary();
                    break;
                case 'response':
                    $obj =  new ResponseLibrary();
                    break;
                case 'code':
                    $obj =  new CodeLibrary();
                    break;
            }
            if(!is_null($obj)){
                self::$instances[$key] = $obj;
            }
        }
        return self::$instances[$key];
    }

}