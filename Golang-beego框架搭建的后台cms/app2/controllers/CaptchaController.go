package controllers

import (
	"github.com/dchest/captcha"
	"github.com/astaxie/beego"
)

// operations for Captcha
type CaptchaController struct {
	beego.Controller
}

func (this *CaptchaController) VerifyCaptcha() bool{
	captchaId := this.GetString("captchaId")
	captchaValue := this.GetString("captcha")
	if !captcha.VerifyString(captchaId, captchaValue) {
		return false
	} else {
		return true
	}
}

