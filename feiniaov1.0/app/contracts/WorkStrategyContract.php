<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 16:58
 */
namespace app\contracts;

/**
 * --接口契约-- 工作的策略接口
 */
interface WorkStrategyContract
{

    public function chooseLanguage();

    public function develop();

}
