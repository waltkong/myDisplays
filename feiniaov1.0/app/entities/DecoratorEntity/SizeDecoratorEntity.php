<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 15:04
 */
namespace app\entities\DecoratorEntity;

use app\contracts\DecoratorContract;

class SizeDecoratorEntity implements DecoratorContract
{
    protected $size;

    public function __construct ($size)
    {
        $this->size = $size;
    }

    public function before ()
    {
        echo "增加文字大小修饰";
        echo "<div style='font-size: {$this->size}'>";
    }

    public function after ()
    {
        echo "</div>";
        echo "结束文字大小修饰";
    }


}