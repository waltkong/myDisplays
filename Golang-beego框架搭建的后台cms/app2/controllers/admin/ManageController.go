package admin

import (
	"github.com/astaxie/beego/orm"
	"myapp/app2/models"
	"strconv"
	"time"
)

type ManageController struct {
	BaseController
}

type AdminFormData struct {
	keyword string
	page string
	offset string
	startTime string
	endTime string
}

func (this *ManageController) Index(){
	//if this.GetSession("IS_SUPER") != true{
	//	this.Ctx.Redirect(302,"/admin/index/index")
	//}
	this.TplName = "admin/manage/index.html"
}


func (this *ManageController) Query(){
	formData := AdminFormData{
		keyword:this.Input().Get( "keyword" ),
		startTime:this.Input().Get( "startTime" ),
		endTime:this.Input().Get( "startTime" ),
		page:this.Input().Get( "page" ),
		offset:this.Input().Get( "offset" ),
	}
	var container []*models.AdminModel
	o := orm.NewOrm()
	qs := o.QueryTable("cms_admin")
	cond := orm.NewCondition()
	if formData.keyword != ""{
		cond = cond.And("name",formData.keyword)
	}
	if formData.startTime != ""{
		cond = cond.And("create_time__egt",formData.startTime)
	}
	if formData.endTime != ""{
		cond = cond.And("create_time__elt",formData.endTime)
	}
	if formData.page == ""{
		formData.page = "0"   //第0页
	}
	if formData.offset == ""{
		formData.offset = "20"   //每页20条
	}
	//pageInt,_ := strconv.Atoi(formData.page)
	//offsetInt,_ := strconv.Atoi(formData.offset)
	//limitStart := pageInt * offsetInt
	//num,err := qs.SetCond(cond).Limit(limitStart, offsetInt).All(&container)
	num,err := qs.SetCond(cond).All(&container)
	if err != nil {
		this.Data["json"] = map[string]interface{}{"status":-1, "msg": err.Error()}
	} else {
		this.Data["json"] = map[string]interface{}{"status":1, "msg": "ok","totals":num,"datas":container}
	}
	this.ServeJSON()
}


func (this *ManageController) Edit(){
	id := this.Ctx.Input.Param(":id")  //一定要用param接收参数
	o := orm.NewOrm()
	pkId,_ := strconv.Atoi(id)
	container := models.AdminModel{Id: pkId}
	err := o.Read(&container)
	if err == nil {
		this.Data["ThisRow"] = container
		this.TplName = "admin/manage/edit.html"
	}
}

func (this *ManageController) DoEdit(){
	id := this.Ctx.Input.Param(":id")  //一定要用param接收参数
	o := orm.NewOrm()
	pkId,_ := strconv.Atoi(id)
	container := models.AdminModel{Id: pkId}
	err := o.Read(&container)
	if err != nil {
		this.Data["json"] = map[string]interface{}{"status":-1, "msg": err.Error()}
		this.ServeJSON()
	}else {
		container.Name = this.Input().Get("name")
		container.Phone = this.Input().Get("phone")
		container.Email = this.Input().Get("email")
		container.Comment = this.Input().Get("comment")
		if this.Input().Get("roleId") == "1" {
			container.IsSuper = "1"
		} else {
			container.IsSuper = "-1"
		}
		num, err := o.Update(&container)
		if err != nil && num != 0 {
			this.Data["json"] = map[string]interface{}{"status":1, "msg": "操作成功"}
		}else {
			this.Data["json"] = map[string]interface{}{"status":-1, "msg": err.Error()}
		}
		this.ServeJSON()
	}
}

func (this *ManageController) Add(){
	this.TplName = "admin/manage/add.html"
}

func (this *ManageController) DoAdd(){
	o := orm.NewOrm()
	var container models.AdminModel
	container.Name = this.Input().Get("name")
	err := o.Read(&container,"name")
	if err == orm.ErrNoRows {    //如果查询不到，说明正常
		container.Password = this.Input().Get("password")
		container.Phone = this.Input().Get("phone")
		container.Email = this.Input().Get("email")
		container.Comment = this.Input().Get("comment")
		container.CreateTime = strconv.Itoa(int(time.Now().Unix()))
		if this.Input().Get("roleId") == "1" {
			container.IsSuper = "1"
		} else {
			container.IsSuper = "-1"
		}
		o.Insert(&container)
		this.Data["json"] = map[string]interface{}{"status":1, "msg": "操作成功"}
	}else {
		this.Data["json"] = map[string]interface{}{"status":-1, "msg": "已存在用户"}
	}
	this.ServeJSON()
}

func (this *ManageController) Del(){
	id := this.Ctx.Input.Param(":id")   //一定要用param接收参数
	pkId,_ := strconv.Atoi(id)
	container := models.AdminModel{Id: pkId}
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

