package routers

import (
	"feiniao1/controllers"
	"github.com/astaxie/beego"
	"feiniao1/controllers/admin"
	"github.com/astaxie/beego/context"
)

func init() {
    beego.Router("/", &controllers.MainController{})

    //管理员登录
	beego.Router("/admin/public/login",&admin.PublicController{},"*:Login")
	beego.Router("/admin/index/index",&admin.IndexController{},"*:Index")

	beego.Router("/admin/menu/index", &admin.MenuController{},"*:Index")
	beego.Router("/admin/menu/add", &admin.MenuController{},"*:Add")
	beego.Router("/admin/menu/edit/?:id", &admin.MenuController{},"*:Edit")

	beego.Router("/admin/news/index", &admin.NewsController{},"*:Index")
	beego.Router("/admin/news/add", &admin.MenuController{},"*:Add")
	beego.Router("/admin/news/edit/?:id", &admin.MenuController{},"*:Edit")

	beego.Get("/admin/menu/edit22/?:id",func(ctx *context.Context){
		ctx.Output.Body([]byte("hello world"))
	})

}
