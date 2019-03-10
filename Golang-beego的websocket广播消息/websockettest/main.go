package main

import (
	_ "websockettest/routers"
	"github.com/astaxie/beego"
)

//func init()  {
//	orm.RegisterDriver("mysql",orm.DRMySQL)
//	orm.RegisterDataBase("default", "mysql", "root:root@/lims?charset=utf8")
//}


func main() {
	beego.Run()
}

