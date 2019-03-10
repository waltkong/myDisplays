package routers

import (
	"websockettest/controllers"
	"github.com/astaxie/beego"
)

func init() {
	beego.Router("/", &controllers.MainController{})
	beego.Router("/login", &controllers.LoginController{})
	beego.Router("/ws", &controllers.MyWebSocketController{})
	beego.Router("/send", &controllers.SendController{})  //这个是客户端发送页面
}
