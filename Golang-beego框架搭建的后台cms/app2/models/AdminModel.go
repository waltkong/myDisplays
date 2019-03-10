package models

import (
	"github.com/astaxie/beego/orm"
	"myapp/app2/controllers/common"
)

type AdminModel struct {
	BaseModel
	Id int            `orm:"column(id)"`
	Name string   `orm:"column(name)"`
	Password string   `orm:"column(password)"`
	Email string       `orm:"column(email)"`
	Phone string       `orm:"column(phone)"`
	CreateTime string    `orm:"column(create_time)"`
	IsSuper string   `orm:"column(is_super)"`
	Comment string  `orm:"column(comment)"`
}

func init()  {
	orm.RegisterModelWithPrefix("cms_", new(AdminModel))
}

func (m *AdminModel) TableName()  string{
	return "admin"
}

func (m *AdminModel) TableEngine ()  string{
	return "INNODB"
}

func GetAdminList(keyword string ,limit string) (int,[]AdminModel){
	var objs []AdminModel
	o := orm.NewOrm()
	adminModel := new(AdminModel)
	qs := o.QueryTable(adminModel) // 返回 QuerySeter
	if keyword != ""{
		qs.Filter("name",keyword)
	}
	num,_ :=qs.Limit(limit).OrderBy("id asc").All(&objs)
	return int(num),objs
}

func GetAdminCount(keyword string) int{
	o := orm.NewOrm()
	adminModel := new(AdminModel)
	qs := o.QueryTable(adminModel) // 返回 QuerySeter
	if keyword != ""{
		qs.Filter("name",keyword)
	}
	num,_ :=qs.Count()
	return int(num)
}


//func GetAdminCount(keyword string) common.CommonReply{
//	o := orm.NewOrm()
//	var adminObjs []AdminModel
//	sql := "select count(id) from cms_admin "
//	if keyword != "" {
//		sql += " where name = " + keyword
//	}
//	num,err := o.Raw(sql).QueryRows(&adminObjs)
//	if err != nil {
//		return  common.CommonReply{
//			Status:"-1",
//			Msg:err.Error(),
//		}
//	}else {
//		return common.CommonReply{
//			Status:"1",
//			Msg:strconv.Itoa(int(num)),
//		}
//	}
//}
//
//func GetAdminList(keyword,page,offset string) (reply common.CommonReply,objs []AdminModel){
//	o := orm.NewOrm()
//	var adminObjs []AdminModel
//	sql := "select * from cms_admin "
//	if keyword != "" {
//		sql += " where name = " + keyword
//	}
//	pageInt,_ := strconv.Atoi(page)
//	offsetInt,_ := strconv.Atoi(offset)
//	limitStart := strconv.Itoa(pageInt*offsetInt)
//	limitEnd := strconv.Itoa(pageInt*offsetInt + offsetInt)
//	sql += " limit " + limitStart + "," + limitEnd
//
//	fmt.Println("sql:" + sql)
//	num,err := o.Raw(sql).QueryRows(&adminObjs)
//	if err != nil {
//		reply = common.CommonReply{
//			Status:"-1",
//			Msg:err.Error(),
//		}
//	}else {
//		if num == 0 {
//			reply = common.CommonReply{
//				Status:"0",
//				Msg:"找不到数据",
//			}
//		}else {
//			reply = common.CommonReply{
//				Status:"1",
//				Msg:"ok",
//			}
//		}
//	}
//	return reply,adminObjs
//}



func CheckAdmin(name string,pw string) (reply common.CommonReply,obj AdminModel) {
	o := orm.NewOrm()
	adminObj := AdminModel{Name: name}
	err := o.Read(&adminObj, "Name")   //注意指明字段，默认主键
	if err != nil {
		reply = common.CommonReply{
			Status:"-1",
			Msg:err.Error(),
		}
		return reply,adminObj
	}else{
		if adminObj.Password != pw{
			reply = common.CommonReply{
				Status:"0",
				Msg:"用户名或者密码不正确",
			}
		}else{
			reply = common.CommonReply{
				Status:"1",
				Msg:"OK",
			}
		}
		return reply,adminObj
	}
}
