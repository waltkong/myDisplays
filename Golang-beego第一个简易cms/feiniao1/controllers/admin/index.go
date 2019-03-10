package admin

import (
	"github.com/astaxie/beego"
	"github.com/astaxie/beego/orm"
	"feiniao1/models/admin"
)

//主页控制器
type IndexController struct {
	beego.Controller
}

func ( c *IndexController) Index()  {
	menus := c.GetMenus()
	//t, _ := json.Marshal(b)
	//c.Ctx.WriteString(string(t))
	c.Data["Menus"] = menus
	c.TplName = "admin/index/index.html"
}

//获取状态值正常的所有的菜单
func ( c *IndexController) GetMenus()  ([]*admin.MenuModel){
	var menus []*admin.MenuModel
	o := orm.NewOrm()
	menuModel := new(admin.MenuModel)
	qs := o.QueryTable(menuModel) // 返回 QuerySeter
	num,_ :=qs.Filter("status",1).Filter("type",1).Limit(100).OrderBy("id").All(&menus)
	if num ==0 {
		return nil
	}
	return menus
}
