package admin

import "github.com/astaxie/beego/orm"

type MenuModel struct {
	Id int            `orm:"column(id)"`
	Name string   `orm:"column(name)"`
	Status string        `orm:"column(status)"`
	M string        `orm:"column(m)"`
	C string        `orm:"column(c)"`
	F string        `orm:"column(f)"`
	Type string    `orm:"column(type)"`
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