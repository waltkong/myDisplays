<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/22
 * Time: 15:04
 */
namespace app\entities\DecoratorEntity;

use app\contracts\DecoratorContract;

class Text{

    protected $decorators = [];

    public function index(){
        $this->beforeOperation();
        echo "--我是需要被修饰的文字--";
        $this->afterOperation();

    }

    /**
     * 追加装饰器
     * @param DecoratorContract $decoratorContract
     */
    public function addDecorator( DecoratorContract $decoratorContract){
        $this->decorators[] = $decoratorContract;
    }

    /**
     * 执行所有装饰器的前置操作
     */
    private function beforeOperation(){
        foreach ($this->decorators as $decorator){
            $decorator->before();
        }
    }

    /**
     * 执行所有装饰器的后置操作
     */
    private function afterOperation(){
        foreach ($this->decorators as $decorator){
            $decorator->after();
        }
    }

}