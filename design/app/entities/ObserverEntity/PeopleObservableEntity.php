<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 15:12
 */
namespace app\entities\ObserverEntity;

use app\contracts\ObservableContract;

class PeopleObservableEntity implements ObservableContract {

    /**
     * 观察者组
     */
    private $_observers = array();

    /**
     * 实现接口-- 添加观察者
     * @param $observer
     */
    public function addObserver( $observer ){
        $this->_observers[]= $observer;
    }

    /**
     *  实现接口-- 删除观察者
     * @param $observerName
     */
    public function removeObserver( $observerName) {
        foreach($this->_observers as $index => $observer) {
            if ($observer->getName() === $observerName) {
                array_splice($this->_observers, $index, 1);
                return;
            }
        }
    }

    /**
     * 向观察者发送事件
     */
    public function sendMsg( $name ){
        foreach( $this->_observers as $obs ){
            $obs->onSendMsg( $this, $name );
        }
    }
}