package admin

import (
	"github.com/astaxie/beego"
)

//公共控制器
type BaseController struct {
	IsLogin bool
	IsSuper bool
	beego.Controller
	OtherStateController
}

//存储一些状态
type OtherStateController struct {
	NowGameID string  //当前操作的游戏id
	NowPlatformID string    //当前操作的平台ID
}