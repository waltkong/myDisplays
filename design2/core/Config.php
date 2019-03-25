<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/25
 * Time: 10:26
 */
class Config{

    /**
     * 保存配置信息
     */
    public $settings = [];

    static public $instance;

    private function __construct (){}

    private function __clone (){}

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new self();
            self::$instance->load_configs();
        }
        return self::$instance;
    }

    /**
     * 加载配置文件
     */
    public function load_configs(){
        $configFolder = BASE_PATH.'conf/';
        $files = scandir($configFolder);
        foreach ($files as $file){
            if(!in_array($file,['.','..'])){
                require_once $configFolder.$file ;
                $vars = get_defined_vars ();
                foreach ($vars as $key => $val){
                    if(strpos($key,'_config') !== false){    //必须匹配到 _config的字样的变量 才算是配置的键
                        $this->settings[$key] = $val;
                    }
                }
                unset($file);
            }
        }
    }
    /**
     * 读取配置
     */
    public function get($key,$default=null){
        return isset($this->settings[$key]) ? $this->settings[$key]:$default ;
    }
    /**
     * 动态设置配置
     */
    public function set($key,$val){
        $this->settings[$key] = $val;
    }
    /**
     * 删除配置
     */
    public function delete($key){
        if( isset($this->settings[$key]) ) {
            unset($this->settings[$key]);
        }
    }
}