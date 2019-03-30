<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 17:03
 */
namespace app\entities\StrategyEntity;

use app\contracts\WorkStrategyContract;

class PhperStrategyEntity implements WorkStrategyContract
{

    public function chooseLanguage ()
    {
        echo "use php !<br>";
    }


    public function develop(){
        echo "开发周期超快，执行效率一般<br>";
    }
}
