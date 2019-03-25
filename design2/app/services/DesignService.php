<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 15:19
 */
namespace app\services;

use app\entities\DecoratorEntity\ColorDecoratorEntity;
use app\entities\DecoratorEntity\SizeDecoratorEntity;
use app\entities\DecoratorEntity\Text;
use app\entities\ObserverEntity\PeopleObservableEntity;
use app\entities\ObserverEntity\QingtongObserverEntity;
use app\entities\ObserverEntity\WangzheObserverEntity;
use app\entities\ProxyEntity\NetworkProxyEntity;
use app\entities\ProxyEntity\VpnEntity;
use app\entities\StrategyEntity\PhperStrategyEntity;
use app\entities\StrategyEntity\Worker;


class DesignService {
    /**
     * 观察者模式调用
     */
    public function observer(){
        $observerGroup = new PeopleObservableEntity();
        $Bronze = new QingtongObserverEntity();
        $King = new WangzheObserverEntity();

        //30min得60分的是青铜以上级别
        $observerGroup->addObserver($Bronze);
        $observerGroup->addObserver($King);
        $observerGroup->sendMsg([
            'score' => '60',
            'time' => '30min',
        ]);

        //60min得100分的是王者，所以不再通知给青铜，只通知王者。 移除青铜对象
        $observerGroup->removeObserver($Bronze->getName());
        $observerGroup->sendMsg([
            'score' => '100',
            'time' => '60min',
        ]);
    }
    /**
     * 装饰器模式调用
     */
    public function decorator(){
        $color = new ColorDecoratorEntity("blue");
        $size = new SizeDecoratorEntity("32");
        $text = new Text();
        $text->index();
        echo "<hr>";
        $text->addDecorator($color);
        $text->index();
        echo "<hr>";
        $text->addDecorator($size);
        $text->index();
        echo "<hr>";
    }
    /**
     *
     * 代理模式调用
     */
    public function proxy(){
        $vpn = new VpnEntity("马云");
        $proxy = new NetworkProxyEntity($vpn);
        $proxy->connect();
        $proxy->visitWebsite();
    }
    /**
     * 策略模式调用
     */
    public function strategy(){
        $php = new PhperStrategyEntity();
        $work = new Worker($php);
        $work->do_work();
    }


}
