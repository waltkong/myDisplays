package admin

import (
	"github.com/astaxie/beego"
	"github.com/astaxie/beego/orm"
	 "feiniao1/models/admin"
)

//登录控制器
type PublicController struct {
	beego.Controller
}

func ( c *PublicController) Login() {
	//c.Ctx.WriteString(c.Ctx.Request.Method)
	if c.Ctx.Request.Method == "GET" {
		if checkCookie(c) == true {
			c.Ctx.Redirect(302,"/admin/index/index")
		}else{
			c.TplName = "admin/public/login.html"
		}
	}else {
		username := c.Input().Get( "username" )
		password := c.Input().Get( "password" )
		if checkAccount( username,password,c ) {
			c.Ctx.SetCookie( "username" , username )
			c.Ctx.SetCookie( "password" , password )
			c.Ctx.Redirect(302,"/admin/index/index")
		}else{
			c.Ctx.WriteString( "用户身份密码不对，请重新输入" )
		}
		return  //不需要再渲染这个页面
	}
}

func checkAccount(username string,password string,c *PublicController)  bool{
	o := orm.NewOrm()
	adminModel := &admin.AdminModel{Username:username}
	err := o.Read(adminModel,"Username")
	if err == orm.ErrNoRows {
		return false
	} else {
		//c.Ctx.WriteString(adminModel.Password)
		if adminModel.Password != password {
			return false
		} else {
			return true
		}
	}
}

func checkCookie(c *PublicController)  bool{
	ck1,err1 :=c.Ctx.Request.Cookie("username")
	ck2,err2 :=c.Ctx.Request.Cookie("password")
	if err1 != nil  || err2 != nil{
		return false
	}
	userName := ck1.Value
	password := ck2.Value
	if userName =="" || password=="" {
		return false
	}
	o := orm.NewOrm()
	adminModel := &admin.AdminModel{Username:userName}
	err := o.Read(adminModel,"Username")
	if err == orm.ErrNoRows {
		return false
	} else {
		if adminModel.Password != password {
			return false
		} else {
			return true
		}
	}
}


