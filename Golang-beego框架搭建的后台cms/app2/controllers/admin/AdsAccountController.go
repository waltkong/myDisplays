package admin

import (
	"myapp/app2/models"
	"github.com/astaxie/beego/orm"
)

type AdsAccountController struct {
	BaseController
}

//func setObject(this *AdsAccountController ){   //设置当前操作的一些数据
//	gameID := this.GetSession("NOW_GAME_ID")
//	if gameID == nil || gameID == ""{
//		gameID = ""
//		this.Data[]
//	}
//	platformID := this.GetSession("NOW_PLATFORM_ID")
//
//}

func (this *AdsAccountController) Index(){
	this.TplName = "admin/adsaccount/index.html"
}

type AdsAccountFormData struct {
	gameId string
	platformId string
	keyword string
	startTime string
	endTime string
	page string
	offset string
}

func (this *AdsAccountController ) Query(){
	formData := AdsAccountFormData{
		gameId:this.Input().Get( "gameId" ),
		platformId:this.Input().Get( "platformId" ),
		keyword:this.Input().Get( "keyword" ),
		startTime:this.Input().Get( "startTime" ),
		endTime:this.Input().Get( "startTime" ),
		page:this.Input().Get( "page" ),
		offset:this.Input().Get( "offset"),
	}

	var container []*models.AdminModel
	o := orm.NewOrm()
	qs := o.QueryTable("cms_admin")
	cond := orm.NewCondition()
	if formData.keyword != ""{
		cond = cond.And("name",formData.keyword)
	}
	if formData.startTime != ""{
		cond = cond.And("create_time__egt",formData.startTime)
	}
	if formData.endTime != ""{
		cond = cond.And("create_time__elt",formData.endTime)
	}
	if formData.page == ""{
		formData.page = "0"   //第0页
	}
	if formData.offset == ""{
		formData.offset = "20"   //每页20条
	}
	//pageInt,_ := strconv.Atoi(formData.page)
	//offsetInt,_ := strconv.Atoi(formData.offset)
	//limitStart := pageInt * offsetInt
	//num,err := qs.SetCond(cond).Limit(limitStart, offsetInt).All(&container)
	num,err := qs.SetCond(cond).All(&container)
	if err != nil {
		this.Data["json"] = map[string]interface{}{"status":-1, "msg": err.Error()}
	} else {
		this.Data["json"] = map[string]interface{}{"status":1, "msg": "ok","totals":num,"datas":container}
	}
	this.ServeJSON()
}

