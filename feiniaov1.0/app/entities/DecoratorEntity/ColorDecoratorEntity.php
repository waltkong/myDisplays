<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 15:04
 */
namespace app\entities\DecoratorEntity;

use app\contracts\DecoratorContract;

class ColorDecoratorEntity implements DecoratorContract
{
    protected $color;

    public function __construct ($color)
    {
        $this->color = $color;
    }

    public function before ()
    {
        echo "增加颜色修饰";
        echo "<div style='color: {$this->color}'>";
    }

    public function after ()
    {
        echo "</div>";
        echo "结束颜色修饰";
    }

}