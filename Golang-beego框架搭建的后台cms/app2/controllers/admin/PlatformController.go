package admin

import (
	"myapp/app2/models"
	"github.com/astaxie/beego/orm"
	"strconv"
	"time"
)

type PlatformController struct {
	BaseController
}

func (this *PlatformController) Index()  {
	this.TplName = "admin/platform/index.html"
}

func (this *PlatformController) Query(){
	var container []*models.PlatformModel
	o := orm.NewOrm()
	qs := o.QueryTable("cms_platform")
	num,err := qs.All(&container)
	if err != nil {
		this.Data["json"] = map[string]interface{}{"status":-1, "msg": err.Error()}
	} else {
		this.Data["json"] = map[string]interface{}{"status":1, "msg": "ok","totals":num,"datas":container}
	}
	this.ServeJSON()
}



//游戏新增
func (this *PlatformController)  DoAdd() {
	o := orm.NewOrm()
	var container models.PlatformModel
	container.Name = this.Input().Get("name")
	err := o.Read(&container,"name")
	if err == orm.ErrNoRows {    //如果查询不到，说明正常
		container.CreateTime = strconv.Itoa(int(time.Now().Unix()))
		o.Insert(&container)
		this.Data["json"] = map[string]interface{}{"status":1, "msg": "操作成功"}
	}else {
		this.Data["json"] = map[string]interface{}{"status":-1, "msg": "已存在游戏名"}
	}
	this.ServeJSON()
}

func (this *PlatformController) Edit(){
	id := this.Ctx.Input.Param(":id")  //一定要用param接收参数
	o := orm.NewOrm()
	pkId,_ := strconv.Atoi(id)
	container := models.PlatformModel{Id: pkId}
	err := o.Read(&container)
	if err == nil {
		this.Data["ThisRow"] = container
		this.TplName = "admin/platform/edit.html"
	}
}


func (this *PlatformController) DoEdit(){
	id := this.Ctx.Input.Param(":id")  //一定要用param接收参数
	o := orm.NewOrm()
	pkId,_ := strconv.Atoi(id)
	container := models.PlatformModel{Id: pkId}
	err := o.Read(&container)
	if err != nil {
		this.Data["json"] = map[string]interface{}{"status":-1, "msg": err.Error()}
		this.ServeJSON()
	}else {
		container.Name = this.Input().Get("name")
		num, err := o.Update(&container)
		if err != nil && num != 0 {
			this.Data["json"] = map[string]interface{}{"status":1, "msg": "操作成功"}
		}else {
			this.Data["json"] = map[string]interface{}{"status":-1, "msg": err.Error()}
		}
		this.ServeJSON()
	}
}

func (this *PlatformController) Del(){
	id := this.Ctx.Input.Param(":id")   //一定要用param接收参数
	pkId,_ := strconv.Atoi(id)
	container := models.PlatformModel{Id: pkId}
	o := orm.NewOrm()
	err := o.Read(&container)
	if err == nil {
		o.Delete(&container)
		this.Data["json"] = map[string]interface{}{"status":1, "msg": "操作成功"}
	} else {
		this.Data["json"] = map[string]interface{}{"status":-1, "msg": this.Ctx.Input.Data()}
	}
	this.ServeJSON()
}


