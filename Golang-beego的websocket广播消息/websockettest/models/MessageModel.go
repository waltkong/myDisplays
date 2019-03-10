package models

import "github.com/astaxie/beego/orm"

type MessageModel struct {
	Id int  `orm:"column(id)"`
	Mtype string `orm:"column(mtype)"`
	Title string `orm:"column(title)"`
	SendID string `orm:"column(sendID)"`
	Content string `orm:"column(content)"`
	Createtime string `orm:"column(create_time)"`
}

type MessageDetailModel struct {
	Id int `orm:"column(id)"`
	Mid string `orm:"column(mid)"`
	Content string `orm:"column(content)"`
	SendID string `orm:"column(send_id)"`
	ReceiveID string `orm:"column(receive_id)"`
	Createtime string `orm:"column(create_time)"`
	Ifread string `orm:"column(if_read)"`
	Iffirst string `orm:"column(if_first)"`
}

func init()  {
	orm.RegisterModelWithPrefix("", new(MessageModel))
	orm.RegisterModelWithPrefix("", new(MessageDetailModel))
}

func (m *MessageModel) TableName()  string{
	return "message"
}
func (m *MessageModel) TableEngine ()  string{
	return "INNODB"
}
func (m *MessageDetailModel) TableName()  string{
	return "message_detail"
}
func (m *MessageDetailModel) TableEngine ()  string{
	return "INNODB"
}