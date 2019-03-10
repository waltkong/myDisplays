package admin

type StateApiController struct {
	BaseController
}

func (this *StateApiController) GameChange(){
	this.SetSession("NOW_GAME_ID",this.Ctx.Input.Param(":id"))    //设置当前操作的游戏对象
	this.Data["json"] = map[string]interface{}{"status":1, "msg":"操作成功"}
	this.ServeJSON()
}

func (this *StateApiController) PlatformChange(){
	this.SetSession("NOW_PLATFORM_ID",this.Ctx.Input.Param(":id"))    //设置当前操作的投放平台对象
	this.Data["json"] = map[string]interface{}{"status":1, "msg":"操作成功"}
	this.ServeJSON()
}
