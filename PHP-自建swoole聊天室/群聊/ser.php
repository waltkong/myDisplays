<?php
$commonPrefix = 'TEST_AAA';
$server = new swoole_websocket_server("0.0.0.0", 9502);
$server->on('open', function($server, $req) {
    echo "connection open: {$req->fd}\n";
});
$server->on('message', function($server, $frame) use($commonPrefix) {
    echo "received message: {$frame->data}\n";
    $receive_data=json_decode($frame->data);
    $redis=new Redis();
    $redis->connect('127.0.0.1', 6379);
    echo "redis connected \n";
    if($receive_data->type=='bind'){
        //关系绑定
        $redis->hSet($commonPrefix.'group_name_'.$receive_data->group_id,$receive_data->name,$frame->fd);    //组里面的所有用户  hash存储  用户名=》资源id[这个值不重要，因为我们用另外一个redis去维护]
        $redis->set($commonPrefix.'user_name_'.$receive_data->name,$frame->fd);    //这个用户的连接资源绑定
        $redis->set($commonPrefix.'fd_'.$frame->fd,$receive_data->name);    //这个用户的连接资源绑定
        $redis->set($commonPrefix.'fd_group_'.$frame->fd,$receive_data->group_id);    //这个用户组的连接资源绑定
    }else{
        //消息发送
        $data['fd']=$frame->fd;
        $data['name']=$receive_data->name;
        $data['data']=$receive_data->msg;
        $sendUsers =  $redis->hkeys($commonPrefix.'group_name_'.$receive_data->group_id);
        foreach($sendUsers as $k => $user){
            $userFd = $redis->get($commonPrefix.'user_name_'.$user);
            if(!empty($userFd)){
                $server->push($userFd, json_encode($data));   //将发送者和消息 json序列化给客户端
            }
        }
    }
});
$server->on('close', function($server, $fd) use($commonPrefix) {
    echo "connection close: {$fd}\n";
    //取消关系绑定
    $redis=new Redis();
    $redis->connect('127.0.0.1', 6379);
    $closeUser = $redis->get($commonPrefix.'fd_'.$fd);   //获取该下线的用户
    $closeGroup = $redis->get($commonPrefix.'fd_group_'.$fd);   //获取该下线的所属用户组
    $redis->del($commonPrefix.'user_name_'.$closeUser);   //将该用户的连接绑定清掉
    $redis->del($commonPrefix.'fd_'.$fd);    ////这个用户的连接资源绑定清掉
    $redis->hdel($commonPrefix.'group_name_'.$closeGroup,$closeUser);   //从组里面去除掉该下线用户
    $redis->del($commonPrefix.'fd_group_'.$fd);    //这个用户组的连接资源绑定删除
});
$server->on('Shutdown', function($server) use($commonPrefix){
    //kill -15 PID 才会触发
    echo "Shutdown。。。\n";
    $redis=new Redis();
    $redis->connect('127.0.0.1', 6379);
    //取消所有关系绑定
    foreach($server->connections as $fd)
    {
        $closeUser = $redis->get($commonPrefix.'fd_'.$fd);   //获取该下线的用户
        $closeGroup = $redis->get($commonPrefix.'fd_group_'.$fd);   //获取该下线的所属用户组
        $redis->del($commonPrefix.'user_name_'.$closeUser);   //将该用户的连接绑定清掉
        $redis->del($commonPrefix.'fd_'.$fd);    ////这个用户的连接资源绑定清掉
        $redis->hdel($commonPrefix.'group_name_'.$closeGroup,$closeUser);   //从组里面去除掉该下线用户
        $redis->del($commonPrefix.'fd_group_'.$fd);    //这个用户组的连接资源绑定删除
    }
});
$server->start();