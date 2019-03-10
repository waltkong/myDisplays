package admin

import (
	."myapp/app2/models"
	"github.com/dchest/captcha"
	"fmt"
)

//登陆控制器
type PublicController struct {
	BaseController
}

func (this *PublicController) Login(){
	if this.GetSession("ADMIN_NAME") != nil {    //如果存在session
		this.Ctx.Redirect(302,"/admin/index/index")
	}else{
		d := struct {
			CaptchaId string
		}{
			captcha.New(),
		}
		this.Data["CaptchaId"] = d.CaptchaId
		this.TplName = "admin/public/login.html"
	}
}

func (this *PublicController) DoLogin(){
	//验证码
	captchaId := this.GetString("captchaId")
	captchaValue := this.GetString("captcha")
	if !captcha.VerifyString(captchaId, captchaValue){
		this.IsLogin = false
		this.Data["json"] = map[string]interface{}{"status":-1, "msg": "验证码错误"}
	}else{
		name := this.Input().Get( "name" )
		password := this.Input().Get( "password" )
		ret,obj := CheckAdmin(name,password)
		if ret.Status == "1"{
			setThisSession(this,obj)
			this.Data["json"] = map[string]interface{}{"status":1, "msg": "登录成功"}
		}else{
			delThisSession(this)
			this.Data["json"] = map[string]interface{}{"status":-1, "msg": ret.Msg}
		}
		fmt.Println("name:"+name)
	}
	this.ServeJSON()
}


func (this *PublicController) Logout(){
	delThisSession(this)
	this.Ctx.Redirect(302,"/admin/public/login")
}

func setThisSession(this *PublicController,obj AdminModel){
	this.SetSession("ADMIN_NAME", obj.Name)
	this.SetSession("ADMIN_ID", obj.Id)
	this.SetSession("IS_LOGIN", true)
	if obj.IsSuper == "1"{
		this.SetSession("IS_SUPER",true)
	}else {
		this.SetSession("IS_SUPER",false)
	}
}

func delThisSession(this *PublicController){
	this.DelSession("ADMIN_NAME")
	this.DelSession("ADMIN_ID")
	this.DelSession("IS_LOGIN")
	this.DelSession("IS_SUPER")
}

