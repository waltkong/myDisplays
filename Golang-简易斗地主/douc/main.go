package main

import (
	"net"
	"log"
	"fmt"
)

func main()  {
	conn,err := net.Dial("tcp","127.0.0.1:8090")
	checkerr(err)
	fmt.Println("连接房间成功")
	fmt.Println("桌子顺序为 农民1=>农民2=>地主=>农民1 ")
	fmt.Println("注意：出牌用英文半角逗号分隔，出完请按回车键")
	fmt.Println("要不起请出0")
	fmt.Println("请输入用户ID！！！【100代表农民1, 101代表农民2 ,102代表地主】")
	defer conn.Close()
	go readFromServer(conn)

	for {
		var talkContent string
		fmt.Scanln(&talkContent)
		if len(talkContent) > 0 {
			_, err = conn.Write([]byte(talkContent))
			if err != nil {
				checkerr(err)
				return
			}
		}
	}
}

func readFromServer(conn net.Conn)  {
	for {
		data := make([]byte, 1024)
		line, err := conn.Read(data)
		if err != nil {
			checkerr(err)
			return
		}
		fmt.Println(string(data[0:line]))
	}
}


func checkerr(err error)  {
	if err != nil {
		log.Fatal("记录出错信息: ", err)
	}
}