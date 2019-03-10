package admin

type LoginStateController struct {
	BaseController
}


func (this *LoginStateController) Index(){
	this.TplName = "admin/loginstate/index.html"
}

