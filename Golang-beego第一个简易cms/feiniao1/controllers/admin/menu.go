package admin
import (
	"github.com/astaxie/beego"
	"github.com/astaxie/beego/orm"
	"feiniao1/models/admin"
	"strconv"
	"feiniao1/controllers/common"
)

//菜单控制器
type MenuController struct {
	IndexController
	beego.Controller
}

func (c *MenuController) Index() {
	leftmenus := c.GetMenus()
	c.Data["Menus"] = leftmenus
	c.Layout = "admin/layout.html"
	c.TplName = "admin/menu/index.html"
}

func (c *MenuController) Add() {
	if c.Ctx.Request.Method == "GET" {
		leftmenus := c.GetMenus()
		c.Data["Menus"] = leftmenus
		c.Layout = "admin/layout.html"
		c.TplName = "admin/menu/add.html"
		return
	}else {
		o := orm.NewOrm()
		var thisRow admin.MenuModel
		thisRow.Name = c.Input().Get( "name" )
		thisRow.Type = c.Input().Get( "type" )
		thisRow.M = c.Input().Get( "m" )
		thisRow.C = c.Input().Get( "c" )
		thisRow.F = c.Input().Get( "f" )
		thisRow.Status = c.Input().Get( "status" )
		_,err := o.Insert(&thisRow)
		if err != nil {
			c.Ctx.WriteString("插入数据出错")
		}else {
			c.Data["json"] = common.JsonReply("1","操作成功")
			c.ServeJSON()
		}
	}
}

func (c *MenuController) Edit()  {
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
		}else {
			thisRow.Name = c.Input().Get( "name" )
			thisRow.Type = c.Input().Get( "type" )
			thisRow.M = c.Input().Get( "m" )
			thisRow.C = c.Input().Get( "c" )
			thisRow.F = c.Input().Get( "f" )
			thisRow.Status = c.Input().Get( "status" )
			if _, err := o.Update(&thisRow); err == nil {
				c.Data["json"] = common.JsonReply("1","操作成功")
				c.ServeJSON()
			}
		}
	}
}

func (c *MenuController) Delete() {
	strid := c.Ctx.Input.Param(":id")
	id,err1 := strconv.Atoi(strid)
	if err1 != nil {
		return
	}
	o := orm.NewOrm()
	thisRow := admin.MenuModel{Id: id}
	err2 := o.Read(&thisRow)
	if err2 == nil {
		if _, err := o.Delete(&thisRow); err == nil {
			c.Data["json"] = common.JsonReply("1","操作成功")
			c.ServeJSON()
		}
	}
}


























