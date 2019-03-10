package models

import "github.com/astaxie/beego/orm"

type PublishRuleModel struct {
	BaseModel
	Id int            `orm:"column(id)"`
	FieldKey string            `orm:"column(field_key)"`
	FieldValue string   `orm:"column(field_value)"`
	GameId string    `orm:"column(game_id)"`
}

func init()  {
	orm.RegisterModelWithPrefix("cms_", new(PublishRuleModel))
}

func (m *PublishRuleModel) TableName()  string{
	return "publish_rule"
}

func (m *PublishRuleModel) TableEngine ()  string{
	return "INNODB"
}



