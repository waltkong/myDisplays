package admin

type ToutiaoController struct {
	BaseController
}

func (this *ToutiaoController) Captcha()  {
	this.Data["imgBase64"] = this.Input().Get("img")
	this.TplName = "admin/toutiao/captcha.html"
}


