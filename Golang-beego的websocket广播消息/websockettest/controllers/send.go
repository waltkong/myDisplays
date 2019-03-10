package controllers

import (
	"github.com/astaxie/beego"
)

type SendController struct {
	beego.Controller
}

func (c *SendController) Get() {
	c.TplName = "send.html"
}
