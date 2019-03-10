package models

import "github.com/astaxie/beego/orm"

type PlatformModel struct {
	BaseModel
	Id int            `orm:"column(id)"`
	Name string   `orm:"column(name)"`
	CreateTime string    `orm:"column(create_time)"`
}

func init()  {
	orm.RegisterModelWithPrefix("cms_", new(PlatformModel))
}

func (m *PlatformModel) TableName()  string{
	return "platform"
}

func (m *PlatformModel) TableEngine ()  string{
	return "INNODB"
}


