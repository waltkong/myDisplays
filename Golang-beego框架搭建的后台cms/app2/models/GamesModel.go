package models

import "github.com/astaxie/beego/orm"

type GamesModel struct {
	BaseModel
	Id int            `orm:"column(id)"`
	Name string   `orm:"column(name)"`
	CreateTime string    `orm:"column(create_time)"`
}

func init()  {
	orm.RegisterModelWithPrefix("cms_", new(GamesModel))
}

func (m *GamesModel) TableName()  string{
	return "games"
}

func (m *GamesModel) TableEngine ()  string{
	return "INNODB"
}

