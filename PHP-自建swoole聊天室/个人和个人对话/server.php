<?php
$server = new swoole_websocket_server("0.0.0.0", 9501);
 
$server->on('open', function($server, $req) {
    echo "connection open: {$req->fd}\n";
});
 
$server->on('message', function($server, $frame) {
    echo "received message: {$frame->data}\n";
    $receive_data=json_decode($frame->data);
    $redis=new Redis();
    $redis->connect('127.0.0.1', 6379);
    echo "redis connected \n";
    if($receive_data->type=='bind'){
        //关系绑定
        $redis->set('fd_'.$receive_data->name,$frame->fd);
        $redis->set('name_'.$frame->fd,$receive_data->name);
    }else{
        //消息发送
        $data['fd']=$frame->fd;
        $data['name']=$receive_data->name;
        $data['data']=$receive_data->msg;
        $server->push($redis->get('fd_'.$receive_data->touser), json_encode($data));
        $server->push($frame->fd, json_encode($data));
    }
});
 
$server->on('close', function($server, $fd) {
    echo "connection close: {$fd}\n";
    //取消关系绑定
    $redis=new Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->del('fd_'.$redis->get('name_'.$fd));
    $redis->del('name_'.$fd);
});
 
$server->on('Shutdown', function($server) {
    //kill -15 PID 才会触发
    echo "Shutdown。。。\n";
    $redis=new Redis();
    $redis->connect('127.0.0.1', 6379);
    //取消所有关系绑定
    foreach($server->connections as $fd)
    {
        $redis->del('fd_'.$redis->get('name_'.$fd));
        $redis->del('name_'.$fd);
    }
});
 
$server->start();