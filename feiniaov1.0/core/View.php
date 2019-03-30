<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/25
 * Time: 18:11
 */
class View
{

    public function parse($path){
        return __VIEW__.$path.'.html';
    }


}