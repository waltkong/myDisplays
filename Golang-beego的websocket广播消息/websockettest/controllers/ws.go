package controllers

import (
	"log"
	"websockettest/models"
	"time"
	"github.com/astaxie/beego"
	"github.com/gorilla/websocket"
	"fmt"
	//"strconv"
	"strconv"
	"net/http"
)

type MyWebSocketController struct {
	beego.Controller
}

// Configure the upgrader
var upgrader = websocket.Upgrader{
	CheckOrigin: func(r *http.Request) bool {
		return true
	},
}

func (c *MyWebSocketController) Get() {
	ws, err := upgrader.Upgrade(c.Ctx.ResponseWriter, c.Ctx.Request, nil)
	if err != nil {
		log.Fatal(err)
	}
	//defer ws.Close()
	//clients[ws] = 0    //初始绑定一个0的用户id  后面把他改过来，改成对应的用户id
	//不断的广播发送到页面上
	for {
		time.Sleep(time.Second * 1)
		var msg models.Message // Read in a new message as JSON and map it to a Message object
		err := ws.ReadJSON(&msg)
		//wstype,p,err := ws.ReadMessage()
		if err != nil {
			log.Printf("页面可能断开啦 ws.ReadJSON error: %v", err)
			delete(clients, ws)
			break
		} else {
			fmt.Println("服务器接收的标题：" + msg.Title)
			fmt.Println(msg)
		}
		//解析前台消息
		myIntID,err := strconv.Atoi(msg.MyID)
		if err != nil {
			fmt.Println("接收到自己的id不是整型" + msg.MyID)
		}else{
			if msg.Shakehand == "1" {    //代表是握手 不是发送消息
				clients[ws] = myIntID         //初始绑定用户id 此次连接的用户的一个map
			} else {
				broadcast <- msg          //广播消息
			}
		}

		//broadcast <- models.Message{Message: time.Now().Format("2006-01-02 15:04:05") +
		//	" : 服务器接收的数据类型" + strconv.Itoa(wstype) +
		//		"服务器接收的数据" + string(p) + " : ip为 " + c.Ctx.Input.IP()}
	}
}


//func (c *MyWebSocketController) getMsgRow(msgid int) (bool,models.MessageModel){
//	o := orm.NewOrm()
//	var msgModel models.MessageModel
//	err := o.QueryTable("message").Filter("id",msgid).One(&msgModel)
//	if err == orm.ErrMultiRows {
//		// 多条的时候报错
//		fmt.Printf("Returned Multi Rows Not One")
//	}
//	if err == orm.ErrNoRows {
//		// 没有找到记录
//		return false,msgModel
//	}
//	return true,msgModel
//}


