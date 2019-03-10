package models

import (
	"github.com/astaxie/beego/orm"
)

type AdsAccountModel struct {
	BaseModel
	Id int            `orm:"column(id)"`
	GameId string   `orm:"column(game_id)"`
	PlatformId string  `orm:"column(platform_id)"`
	Description  string `orm:"column(description)"`
	Name string   `orm:"column(name)"`
	Access string   `orm:"column(access)"`
	CreateTime string    `orm:"column(create_time)"`
}

func init()  {
	orm.RegisterModelWithPrefix("cms_", new(AdsAccountModel))
}

func (m *AdsAccountModel) TableName()  string{
	return "ads_account"
}

func (m *AdsAccountModel) TableEngine ()  string{
	return "INNODB"
}





