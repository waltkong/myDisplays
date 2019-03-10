package routers

import (
	"myapp/app2/controllers"
	"github.com/astaxie/beego"
	"myapp/app2/controllers/admin"
	"github.com/dchest/captcha"
)

func init() {
    beego.Router("/", &controllers.MainController{})

	//管理员登录
	beego.Router("/admin/public/login",&admin.PublicController{},"get:Login")   //登录页面
	beego.Router("/admin/public/login",&admin.PublicController{},"post:DoLogin")   //登录提交
	beego.Router("/admin/public/logout",&admin.PublicController{},"*:Logout")   //退出登录
	beego.Handler("/captcha/*.png", captcha.Server(240, 80))    //验证码请求

	//后台首页
	beego.Router("/admin/index/index",&admin.IndexController{},"get:Index")   //外框路由
	beego.Router("/admin/index/welcome",&admin.IndexController{},"get:Welcome")  //欢迎界面【选择游戏】
	beego.Router("/admin/index/welcome2",&admin.IndexController{},"get:Welcome2")  //欢迎界面2【选择平台】



	//用户管理
	beego.Router("/admin/manage/index",&admin.ManageController{},"get:Index")   //用户列表
	beego.Router("/admin/manage/query",&admin.ManageController{},"get:Query")   //用户列表数据
	beego.Router("/admin/manage/add",&admin.ManageController{},"get:Add")   //用户添加页面
	beego.Router("/admin/manage/add",&admin.ManageController{},"post:DoAdd")   //用户添加提交
	beego.Router("/admin/manage/edit/?:id",&admin.ManageController{},"get:Edit")   //用户更改页面
	beego.Router("/admin/manage/edit/?:id",&admin.ManageController{},"post:DoEdit")   //用户更改
	beego.Router("/admin/manage/del/?:id",&admin.ManageController{},"*:Del")   //用户删除

	//游戏管理
	beego.Router("/admin/games/index",&admin.GamesController{},"get:Index")   //游戏列表
	beego.Router("/admin/games/query",&admin.GamesController{},"get:Query")   //游戏列表数据
	beego.Router("/admin/games/add",&admin.GamesController{},"post:DoAdd")   //游戏添加提交
	beego.Router("/admin/games/edit/?:id",&admin.GamesController{},"get:Edit")   //游戏更改页面
	beego.Router("/admin/games/edit/?:id",&admin.GamesController{},"post:DoEdit")   //游戏更改
	beego.Router("/admin/games/del/?:id",&admin.GamesController{},"*:Del")   //游戏删除

	//平台管理
	beego.Router("/admin/platform/index",&admin.PlatformController{},"get:Index")   //投放平台列表
	beego.Router("/admin/platform/query",&admin.PlatformController{},"get:Query")   //投放平台数据
	beego.Router("/admin/platform/add",&admin.PlatformController{},"post:DoAdd")   //投放平台添加提交
	beego.Router("/admin/platform/edit/?:id",&admin.PlatformController{},"get:Edit")   //投放平台更改页面
	beego.Router("/admin/platform/edit/?:id",&admin.PlatformController{},"post:DoEdit")   //投放平台更改
	beego.Router("/admin/platform/del/?:id",&admin.PlatformController{},"*:Del")   //投放平台删除


	//状态切换Api
	beego.Router("/admin/stateapi/gamechange/?:id",&admin.StateApiController{},"post:GameChange")
	beego.Router("/admin/stateapi/platformchange/?:id",&admin.StateApiController{},"post:PlatformChange")


    //广告账号
	beego.Router("/admin/adsaccount/index",&admin.AdsAccountController{},"get:Index")   //具体广告账号列表 账号管理
	beego.Router("/admin/loginstate/index",&admin.LoginStateController{},"get:Index")   //登录状态


	//投放规则
	beego.Router("/admin/publishrule/index",&admin.PublishRuleController{},"*:Index")
	beego.Router("/admin/publishrule/edit",&admin.PublishRuleController{},"post:DoEdit")

    //头条接口
	beego.Router("/admin/toutiao/captcha",&admin.ToutiaoController{},"*:Captcha")  //头条验证码
}
