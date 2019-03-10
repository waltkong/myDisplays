package admin

import "github.com/astaxie/beego/orm"

type NewsModel struct {
	Id int            `orm:"column(id)"`
	Catid string   `orm:"column(catid)"`
	Title string        `orm:"column(title)"`
	SmallTitle string        `orm:"column(small_title)"`
	TitleFontColor string        `orm:"column(title_font_color)"`
	KeyWords string        `orm:"column(keywords)"`
	Description string    `orm:"column(description)"`
	Posids string			`orm:"column(posids)"`
	Status string         `orm:"column(status)"`
	Username string       `orm:"column(username)"`
	Createtime string      `orm:"column(create_time)"`
	Updatetime string        `orm:"column(update_time)"`
}

type NewsContentModel struct {
	Id int      `orm:"column(id)"`
	Newsid string     `orm:"column(news_id)"`
	Content string     `orm:"column(content)"`
	Createtime string      `orm:"column(create_time)"`
	Updatetime string        `orm:"column(update_time)"`
}

func init()  {
	orm.RegisterModelWithPrefix("cms_", new(NewsModel))
	orm.RegisterModelWithPrefix("cms_", new(NewsContentModel))
}

func (m *NewsModel) TableName()  string{
	return "news"
}

func (m *NewsModel) TableEngine ()  string{
	return "INNODB"
}

func (m *NewsContentModel) TableName()  string{
	return "news_content"
}

func (m *NewsContentModel) TableEngine ()  string{
	return "INNODB"
}