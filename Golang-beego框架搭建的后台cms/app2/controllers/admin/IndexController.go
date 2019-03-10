package admin

import (
	"github.com/astaxie/beego/orm"
	"myapp/app2/models"
)

//后台首页控制器
type IndexController struct {
	BaseController
}


func (this *IndexController) Index(){
	if this.GetSession("IS_LOGIN") != true{
		this.Ctx.Redirect(302,"/admin/public/login")
	}
	this.Data["admin_name"] = this.GetSession("ADMIN_NAME")
	this.TplName = "admin/index/index.html"
}



func (this *IndexController) Welcome(){

	o := orm.NewOrm()
	var gamecontainer []*models.GamesModel
	nums, err := o.QueryTable("cms_games").All(&gamecontainer)  	//获取所有游戏
	if err == nil {
		this.Data["games"] = MyGamesChunk(gamecontainer,4)
		this.Data["games_count"] = nums
	} else {
		this.Data["games_count"] = 0
	}
	this.TplName = "admin/index/welcome.html"
}


func (this *IndexController) Welcome2(){
	o := orm.NewOrm()
	var container []*models.PlatformModel
	nums, err := o.QueryTable("cms_platform").All(&container)  	//获取所有游戏
	if err == nil {
		this.Data["platforms"] = MyPlatformChunk(container,4)
		this.Data["platforms_count"] = nums
	} else {
		this.Data["platforms_count"] = 0
	}
	this.TplName = "admin/index/welcome2.html"
}


func MyPlatformChunk( slice []*models.PlatformModel, eachNum int) ([][]*models.PlatformModel){
	var max int
	max = len(slice)/eachNum
	if len(slice) % eachNum != 0 {
		max ++
	}
	result := make([][]*models.PlatformModel,0)
	for i:=0;i< max;i++{
		start := i*eachNum
		var end int
		if i != max-1{
			end = start + eachNum
		} else {
			end = len(slice)
		}
		result = append(result,slice[start:end])
	}
	return result
}


func MyGamesChunk( slice []*models.GamesModel, eachNum int) ([][]*models.GamesModel){
	var max int
	max = len(slice)/eachNum
	if len(slice) % eachNum != 0 {
		max ++
	}
	result := make([][]*models.GamesModel,0)
	for i:=0;i< max;i++{
		start := i*eachNum
		var end int
		if i != max-1{
			end = start + eachNum
		} else {
			end = len(slice)
		}
		result = append(result,slice[start:end])
	}
	return result
}


