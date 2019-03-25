<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 17:08
 */
namespace app\entities\StrategyEntity;

use app\contracts\WorkStrategyContract;

class Worker
{
    private $_strategy;

    public function __construct (WorkStrategyContract $_strategy)
    {
        $this->_strategy = $_strategy;
    }

    public function do_work(){
        $this->_strategy->chooseLanguage();
        $this->_strategy->develop();
    }
}