<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 17:03
 */
namespace app\entities\StrategyEntity;

use app\contracts\WorkStrategyContract;

class GopherStrategyEntity implements WorkStrategyContract
{

    public function chooseLanguage ()
    {
        echo "use golang !<br>";
    }


    public function develop(){
        echo "开发周期较快，执行效率优秀<br>";
    }
}
