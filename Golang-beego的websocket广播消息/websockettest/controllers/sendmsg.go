package controllers

import (
	"websockettest/models"
	"github.com/gorilla/websocket"
	"fmt"
	"log"
	"strconv"
	"strings"
)

var (
	clients   = make(map[*websocket.Conn]int)
	broadcast = make(chan models.Message)
)

func init() {
	go handleMessages()
}

//广播发送至页面
func handleMessages() {
	for {
		msg := <-broadcast
		fmt.Println("多少个客户端连接： ", len(clients))
		for client,v := range clients {
			fmt.Println(msg)
			strByte := strings.Split(msg.RecID, ",")          //接收来的是逗号拼好的接收者
			for _, v2 := range strByte {
				if strconv.Itoa(v) == v2 {
					err := client.WriteJSON(msg)
					if err != nil {
						log.Printf("client.WriteJSON error: %v", err)
						client.Close()
						delete(clients, client)
					}
					log.Println(" 用户id为"+strconv.Itoa(v))
				}
			}
		}
	}
}
