package main

import (
	_ "myapp/app2/routers"
	"github.com/astaxie/beego"
	"github.com/astaxie/beego/orm"
	_"github.com/go-sql-driver/mysql"
)

func init()  {
	//注册数据库
	orm.RegisterDriver("mysql",orm.DRMySQL)
	orm.RegisterDataBase("default", "mysql", "root:root@/beego_app1?charset=utf8")
}

func main() {
	//开启session
	beego.BConfig.WebConfig.Session.SessionOn = true

	beego.Run()
}

