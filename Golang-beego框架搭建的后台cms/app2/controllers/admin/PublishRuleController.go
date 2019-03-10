package admin

import (
	"github.com/astaxie/beego/orm"
	"myapp/app2/models"
)

//投放规则
type PublishRuleController struct {
	BaseController
}

func (this *PublishRuleController) Index(){
	if this.Ctx.Request.Method == "GET"{
		this.TplName = "admin/publishrule/index.html"
	}else{
		gameID := this.Input().Get( "gameID" )
		o := orm.NewOrm()
		var pmodels []models.PublishRuleModel
		o.QueryTable("cms_publish_rule").Filter("game_id", gameID).All(&pmodels)
		this.Data["json"] = map[string]interface{}{"status":1, "msg": pmodels}
		this.ServeJSON()
	}
}

type PublishFormData struct {
	gameID string
	consume_max string
	convert_cost_max string
	convert_num_max string
	remain_money_min string
	ltv_num_min string
	ltv_convert_num_max string
}

func (this *PublishRuleController) DoEdit(){
	var publishFormObj = PublishFormData{
		gameID:this.Input().Get( "gameID" ),
		consume_max:this.Input().Get( "consume_max" ),
		convert_cost_max:this.Input().Get( "convert_cost_max" ),
		convert_num_max:this.Input().Get( "convert_num_max" ),
		remain_money_min:this.Input().Get( "remain_money_min" ),
		ltv_num_min:this.Input().Get( "ltv_num_min" ),
		ltv_convert_num_max:this.Input().Get( "ltv_convert_num_max" ),
	}
	o := orm.NewOrm()
	RuleModelObj := models.PublishRuleModel{GameId: publishFormObj.gameID}
	err := o.Read(&RuleModelObj, "GameId")
	if err == orm.ErrNoRows{    //如果查询不到就添加
		addArr := []models.PublishRuleModel{
			{FieldKey:"consume_max",FieldValue:publishFormObj.consume_max,GameId:publishFormObj.gameID},
			{FieldKey:"convert_cost_max",FieldValue:publishFormObj.convert_cost_max,GameId:publishFormObj.gameID},
			{FieldKey:"convert_num_max",FieldValue:publishFormObj.convert_num_max,GameId:publishFormObj.gameID},
			{FieldKey:"remain_money_min",FieldValue:publishFormObj.remain_money_min,GameId:publishFormObj.gameID},
			{FieldKey:"ltv_num_min",FieldValue:publishFormObj.ltv_num_min,GameId:publishFormObj.gameID},
			{FieldKey:"ltv_convert_num_max",FieldValue:publishFormObj.ltv_convert_num_max,GameId:publishFormObj.gameID},
		}
		o.InsertMulti(1, addArr)
	}else{   //更新
		o.QueryTable("cms_publish_rule").Filter("game_id", publishFormObj.gameID).Filter("field_key","consume_max").Update(orm.Params{
			"field_value": publishFormObj.consume_max,
		})
		o.QueryTable("cms_publish_rule").Filter("game_id", publishFormObj.gameID).Filter("field_key","convert_cost_max").Update(orm.Params{
			"field_value": publishFormObj.convert_cost_max,
		})
		o.QueryTable("cms_publish_rule").Filter("game_id", publishFormObj.gameID).Filter("field_key","convert_num_max").Update(orm.Params{
			"field_value": publishFormObj.convert_num_max,
		})
		o.QueryTable("cms_publish_rule").Filter("game_id", publishFormObj.gameID).Filter("field_key","remain_money_min").Update(orm.Params{
			"field_value": publishFormObj.remain_money_min,
		})
		o.QueryTable("cms_publish_rule").Filter("game_id", publishFormObj.gameID).Filter("field_key","ltv_num_min").Update(orm.Params{
			"field_value": publishFormObj.ltv_num_min,
		})
		o.QueryTable("cms_publish_rule").Filter("game_id", publishFormObj.gameID).Filter("field_key","ltv_convert_num_max").Update(orm.Params{
			"field_value": publishFormObj.ltv_convert_num_max,
		})
	}
	this.Data["json"] = map[string]interface{}{"status":1, "msg": "操作成功"}
	this.ServeJSON()
}