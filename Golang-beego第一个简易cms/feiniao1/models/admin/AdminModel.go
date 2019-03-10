package admin

import "github.com/astaxie/beego/orm"

type AdminModel struct {
	Id int            `orm:"column(id)"`
	Username string   `orm:"column(username)"`
	Password string   `orm:"column(password)"`
	Email string       `orm:"column(email)"`
	Lastlogintime string  `orm:"column(lastlogintime)"`
	Status string        `orm:"column(status)"`
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



