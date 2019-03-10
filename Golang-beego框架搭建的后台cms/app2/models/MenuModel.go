package models

import (
	"github.com/astaxie/beego/orm"
	"myapp/app2/controllers/common"
	"fmt"
	"strconv"
)

type MenuModel struct {
	BaseModel
	Id int            `orm:"column(id)"`
	Name string   `orm:"column(name)"`
	Module string    `orm:"column(module)"`
	MenuRoute string     `orm:"column(menu_route)"`
	Pid string    `orm:"column(pid)"`
	Level string      `orm:"column(level)"`
	IsMenu string    `orm:"column(is_menu)"`
	IfShow string   `orm:"column(if_show)"`
	CreateTime string  `orm:"column(create_time)"`
	Order  string  `orm:"column(order)"`
}


func init()  {
	orm.RegisterModelWithPrefix("cms_", new(MenuModel))
}

func (m *MenuModel) TableName()  string{
	return "menu"
}

func (m *MenuModel) TableEngine ()  string{
	return "INNODB"
}

//获取首页顶部导航菜单
func GetTopNavMenu() (reply common.CommonReply, menus []*MenuModel){
	o := orm.NewOrm()
	menuObj := new(MenuModel)
	qs := o.QueryTable(menuObj)  // 返回 QuerySeter
	num,err :=qs.Filter("is_menu",1).Filter("if_show",1).Filter("level",1).OrderBy("order").All(&menus)
	if err != nil {
		reply = common.CommonReply{
			Status:"-1",
			Msg:err.Error(),
		}
		return reply,menus
	}else {
		if num == 0 {
			reply = common.CommonReply{
				Status:"0",
				Msg:"找不到数据",
			}
			return reply,menus
		}else {
			reply = common.CommonReply{
				Status:"1",
				Msg:"ok",
			}
			return reply,menus
		}
	}
}

//获取该导航页下的子菜单 【子菜单最多两级】
func GetSubMenu(pid string) (reply common.CommonReply, objArr []*MenuModel){
	var menus []*MenuModel
	o := orm.NewOrm()
	menuObj := new(MenuModel)
	qs := o.QueryTable(menuObj)  // 返回 QuerySeter
	num,err :=qs.Filter("pid",pid).Filter("is_menu","1").Filter("if_show","1").Filter("level","2").OrderBy("order").All(&menus)
	if err != nil  || num== 0{
		reply = common.CommonReply{
			Status:"-1",
			Msg:"找不到数据",
		}
		return reply,menus
	}else {
		var tmp []*MenuModel

		for k, v := range menus{
			fmt.Println("haha1:"+ strconv.Itoa(k))
			tmp = append(tmp,v)
			fmt.Println(tmp)
			querySetter := o.QueryTable(new(MenuModel))
			var subMenus []*MenuModel
			num,err := querySetter.Filter("pid",v.Id).Filter("is_menu","1").Filter("if_show","1").Filter("level","2").OrderBy("order").All(&subMenus)

			if err == nil && num > 0 {
				fmt.Println("haha2:"+ strconv.Itoa(k))
				for _,v2 := range subMenus{
					tmp = append(tmp,v2)
				}
			}
		}

		reply = common.CommonReply{
			Status:"1",
			Msg:"ok",
		}
		return reply,tmp
	}
}