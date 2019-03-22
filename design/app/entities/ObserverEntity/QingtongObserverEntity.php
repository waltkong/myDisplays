<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/21
 * Time: 15:22
 */
namespace app\entities\ObserverEntity;

use app\contracts\ObserverContract;

class QingtongObserverEntity implements ObserverContract{

    /**
     * Implement onSendMsg() method.
     *
     */
    public function onSendMsg ( $sender, $data )
    {
        echo "我们是青铜... do something...";
        var_dump($sender);
        var_dump($data);
    }

    /**
     * Implement getName() method.
     *
     */
    public function getName ()
    {
        return 'QingtongObserverEntity';
    }

}