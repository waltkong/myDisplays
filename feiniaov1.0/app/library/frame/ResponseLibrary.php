<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/29
 * Time: 11:34
 */

namespace app\library\frame;

class ResponseLibrary
{
    /**
     * 以模版形式响应  加载视图模板,纯html文件，不需要向模板传递数据
     * @param $path
     * @return bool
     */
    public function view( $path = 'welcome'){
        $view = new \View();
        $path =  $view->parse($path);
        echo file_get_contents($path);
        return true;
    }

    /**
     * json格式响应
     * @param $data
     */
    public function json( $data){
        return json_response($data);
    }

}