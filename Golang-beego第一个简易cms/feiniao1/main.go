package main

import (
	_ "feiniao1/routers"
	"github.com/astaxie/beego"
	"github.com/astaxie/beego/orm"
	_"github.com/go-sql-driver/mysql"

)

func init()  {
	orm.RegisterDriver("mysql",orm.DRMySQL)
	orm.RegisterDataBase("default", "mysql", "root:root@/feiniao1?charset=utf8")
}

func main() {
	beego.Run()
}

