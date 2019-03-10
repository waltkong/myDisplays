package controllers

import (
	"github.com/astaxie/beego"
	//"time"
	//"websockettest/models"
)

type LoginController struct {
	beego.Controller
}

func (c *LoginController) Get() {
	//msg := models.Message{Message: time.Now().Format("2006-01-02 15:04:05") + " : ip为 " + c.Ctx.Input.IP() + "的用户登录"}
	//broadcast <- msg
	//c.TplName = "login.html"
}