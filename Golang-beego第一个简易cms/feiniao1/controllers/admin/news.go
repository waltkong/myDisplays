package admin

import (
	"github.com/astaxie/beego"
	"github.com/astaxie/beego/orm"
	"feiniao1/models/admin"
	"strconv"
)

//新闻控制器
type NewsController struct {
	IndexController
	beego.Controller
}

func (c *NewsController) Index() {
	c.Data["Menus"] = c.GetMenus()
	c.Data["BarMenus"] = c.getBarMenus()
	c.Data["NewsNum"],c.Data["News"] = c.getNews()
	c.Layout = "admin/layout.html"
	c.TplName = "admin/news/index.html"
}


func (c *NewsController) Edit()  {
	strid := c.Ctx.Input.Param(":id")
	id,err1 := strconv.Atoi(strid)
	if err1 != nil {
		return
	}
	o := orm.NewOrm()
	thisRow := admin.MenuModel{Id: id}
	err2 := o.Read(&thisRow)
	if err2 == nil {
		if c.Ctx.Request.Method == "GET" {
			leftmenus := c.GetMenus()
			c.Data["Menus"] = leftmenus
			c.Data["ThisRow"] = thisRow
			c.Layout = "admin/layout.html"
			c.TplName = "admin/menu/edit.html"
		}
	}
}




func (c *NewsController) getNews()  (int64 ,[]*admin.NewsModel){
	var news []*admin.NewsModel
	o := orm.NewOrm()
	newsmodel := new(admin.NewsModel)
	qs := o.QueryTable(newsmodel) // 返回 QuerySeter
	num,_ :=qs.Filter("status",1).Limit(100).OrderBy("id").All(&news)
	if num ==0 {
		return 0,nil
	}
	return num,news
}


func (c *NewsController) getBarMenus()  []*admin.MenuModel{
	var bars []*admin.MenuModel
	o := orm.NewOrm()
	menuModel := new(admin.MenuModel)
	qs := o.QueryTable(menuModel) // 返回 QuerySeter
	num,_ :=qs.Filter("status",1).Filter("type",0).Limit(100).OrderBy("id").All(&bars)
	if num ==0 {
		return nil
	}
	return bars
}

