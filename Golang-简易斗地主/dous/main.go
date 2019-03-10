package main
import (
	"net"
	"fmt"
	"strconv"
	"math/rand"
	"time"
	"strings"
	"sort"
)
var (
	//扑克牌
	pukes = []string{"3","3","3","3","4","4","4","4","5","5","5","5","6","6","6","6","7","7","7","7","8","8","8","8",
		"9","9","9","9","10","10","10","10","J","J","J","J","Q","Q","Q","Q","K","K","K","K","A","A","A","A",
		"2","2","2","2","小鬼","大鬼",
	}
)
func main() {
	ln,err := net.Listen("tcp","127.0.0.1:8090")  	//监听连接
	checkerr(err)
	talkChan := make(map[int]chan string)   	//分配用户的管道
	for {           	//监听客户端连接请求
		fmt.Println("等待客户端连接")
		conn,err := ln.Accept()
		checkerr(err)
		go handleConnection(conn, talkChan)
	}
}
func pukeHash(puke string)  int{       //扑克排序大小表
	switch puke {
	case "J" :
		return 11
	case "Q" :
		return 12
	case "K" :
		return 13
	case "A" :
		return 14
	case "2" :              //把数字2要转化为15
		return 15
	case "小鬼" :
		return 16
	case "大鬼" :
		return 17
	default:
		n,err := strconv.Atoi(puke)
		if err != nil{
			return n
		}else{
			return -1
		}
	}
}
func rPukeHash(puke int ) string {
	if puke>17 || puke<3 {
		return "出错"
	}
	switch puke {
	case 11 :
		return "J"
	case  12:
		return "Q"
	case  13:
		return "K"
	case  14:
		return "A"
	case  15:
		return "2"
	case 16 :
		return "小鬼"
	case 17 :
		return "大鬼"
	default:
		return  strconv.Itoa(puke)
	}
}

func inArray(val string,arr []string) bool{
	for _,v := range arr {
		if val == v {
			return true
		}
	}
	return false
}

//数组里该输是不是出现了n次
func ArrHasN(val string,arr []string,n int)  bool{
	n1 := 0
	for _,v := range arr {
		if val == v {
			n1 += 1
		}
	}
	if n1 == n {
		return true
	} else {
		return false
	}
}

//我的洗牌
func myShuffle(vals []string)  []string{
	r := rand.New(rand.NewSource(time.Now().Unix()))
	n := len(vals)
	ret := make([]string,n)
	for i :=0;i<n;i++ {
		randIndex := r.Intn(len(vals))
		ret[i] = vals[randIndex]
		vals = append(vals[:randIndex], vals[randIndex+1:]...)
	}
	return ret
}
//三个角色分别拿到的随机牌
func getThreeDiv(vals []string)  (a,b,c []string){
	shuffled := myShuffle(vals)
	a = shuffled[0:17]
	b = shuffled[17:34]
	c = shuffled[34:]
	sort.Strings(a)
	sort.Strings(b)
	sort.Strings(c)
	return
}

//逗号连接slice
func implodeArr(vals []string) (str string){
	for i,v := range vals {
		if i==0{
			str += v
		}else {
			str += ","+v
		}
	}
	return str
}
func explodeStr(str string)  []string{
	return strings.Split(str,",")
}
var allowuids = []string{"100","101","102"}    //允许的所有id
var readyUid = make([]string,0)
var thisPuke = pukes  //拷贝一份扑克牌
//获取3份随机牌 农民1 农民2 地主3
var a,b,c = getThreeDiv(thisPuke)
var nextOut = 102   //默认最开始出牌的为地主102号
var recordPrvType = 0    //最开始上一次出牌类型为0
var recordPrvStr = ""     //最开始上一次打的牌为空【对于对子 顺子 3带一等 我们记录最小的那个值】
var recordPrvStrWidth int     //最开始上一次打的牌的长度
//0代表上一轮的类型已经结束 1代表单张 2代表对子 3代表3带1 4代表连对 5代表飞机 6代表炸弹 7代表王炸 8代表顺子
func IfTypeRight(str string) bool {
	//TODO 在客户端要记录 打过的牌一定不能再打了
	a1 := isOneCard(str)
	a2,v2 := isTwoCards(str)
	a3,v3 := isThreeCards(str)
	a4,min4,_,width4 := isSiblings(str)
	a5,min5,_,width5 := isFlight(str)
	a6,v6 := isBoom(str)
	a7 := isBigBoom(str)
	a8,min8,_,width8 := isWords(str)
	if recordPrvType == 0 {   //就不用比较
		if a1 == true {
			recordPrvType = 1
			recordPrvStr = str           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a2  == true {
			recordPrvType = 2
			recordPrvStr = v2           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a3  == true {
			recordPrvType = 3
			recordPrvStr = v3           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a4  == true {
			recordPrvType = 4
			recordPrvStr = min4          //我们就在这里已经确定他是能打出去了的
			recordPrvStrWidth = width4
			return true
		}
		if a5  == true {
			recordPrvType = 5
			recordPrvStr = min5           //我们就在这里已经确定他是能打出去了的
			recordPrvStrWidth = width5
			return true
		}
		if a6  == true {
			recordPrvType = 6
			recordPrvStr = v6           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a7  == true {
			recordPrvType = 0
			recordPrvStr = ""           //都王炸了 下一次肯定是清空都能出的
			return true
		}
		if a8  == true {
			recordPrvType = 8
			recordPrvStr = min8           //我们就在这里已经确定他是能打出去了的
			recordPrvStrWidth = width8
			return true
		}
	}else if recordPrvType == 1 {
		if a1 ==true && pukeHash(str) > pukeHash(recordPrvStr) {
			recordPrvType = 1
			recordPrvStr = str           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a6 == true {      //被炸了
			recordPrvType = 6
			recordPrvStr = v6           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a7==true {      //被王炸了
			recordPrvType = 0
			recordPrvStr = ""           //都王炸了 下一次肯定是清空都能出的
			return true
		}
	} else if recordPrvType == 2 {
		if a2 ==true && pukeHash(v2) > pukeHash(recordPrvStr) {
			recordPrvType = 2
			recordPrvStr = v2           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a6 == true {      //被炸了
			recordPrvType = 6
			recordPrvStr = v6           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a7==true {      //被王炸了
			recordPrvType = 0
			recordPrvStr = ""           //都王炸了 下一次肯定是清空都能出的
			return true
		}
	}else if recordPrvType == 3 {
		if a3 ==true && pukeHash(v3) > pukeHash(recordPrvStr) {
			recordPrvType = 3
			recordPrvStr = v3           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a6 == true {      //被炸了
			recordPrvType = 6
			recordPrvStr = v6           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a7==true {      //被王炸了
			recordPrvType = 0
			recordPrvStr = ""           //都王炸了 下一次肯定是清空都能出的
			return true
		}
	}else if recordPrvType == 4 {
		if a4 ==true && width4==recordPrvStrWidth && pukeHash(min4) > pukeHash(recordPrvStr) {
			recordPrvType = 4
			recordPrvStr = min4           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a6 == true {      //被炸了
			recordPrvType = 6
			recordPrvStr = v6           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a7==true {      //被王炸了
			recordPrvType = 0
			recordPrvStr = ""           //都王炸了 下一次肯定是清空都能出的
			return true
		}
	}else if recordPrvType == 5 {
		if a5 ==true && width5==recordPrvStrWidth && pukeHash(min5) > pukeHash(recordPrvStr) {
			recordPrvType = 5
			recordPrvStr = min5           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a6 == true {      //被炸了
			recordPrvType = 6
			recordPrvStr = v6           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a7==true {      //被王炸了
			recordPrvType = 0
			recordPrvStr = ""           //都王炸了 下一次肯定是清空都能出的
			return true
		}
	}else if recordPrvType == 6 {
		if a6 ==true  && pukeHash(v6) > pukeHash(recordPrvStr) {
			recordPrvType = 6
			recordPrvStr = v6           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a7==true {      //被王炸了
			recordPrvType = 0
			recordPrvStr = ""           //都王炸了 下一次肯定是清空都能出的
			return true
		}
	}else if recordPrvType == 7 {
		return false
	}else if recordPrvType == 8 {
		if a8 ==true && width8==recordPrvStrWidth && pukeHash(min8) > pukeHash(recordPrvStr) {
			recordPrvType = 8
			recordPrvStr = min8           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a6 == true {      //被炸了
			recordPrvType = 6
			recordPrvStr = v6           //我们就在这里已经确定他是能打出去了的
			return true
		}
		if a7==true {      //被王炸了
			recordPrvType = 0
			recordPrvStr = ""           //都王炸了 下一次肯定是清空都能出的
			return true
		}
	}
	return false
}
func handleConnection(conn net.Conn,talkChan map[int]chan string)  {
	var curUid int  //当前用户的uid   [每个线程里一个]
	var closed = make(chan bool)  //关闭的通道
	defer func() {
		fmt.Println("用户 "+strconv.Itoa(curUid)+" 从房间离开")
		conn.Close()
		delete(talkChan,curUid)
	}()
	for {
		data := make([]byte,1024)
		line,err := conn.Read(data)   //接受用户id
		checkerr(err)
		sUid := string(data[0:line])  //string类型的uid
		uid,err := strconv.Atoi(sUid)
		checkerr(err)
		if !inArray(sUid,allowuids) {
			_, err := conn.Write([]byte("用户ID非法,请重新输入"))
			checkerr(err)
			continue
		}
		if inArray(sUid,readyUid) {
			_, err := conn.Write([]byte("此用户已登陆"))
			checkerr(err)
			continue
		}else {
			//将此ID分配为当前ID
			curUid = uid
			talkChan[uid] = make(chan string,2)
			_,err = conn.Write([]byte(getPeople(curUid) + ":已准备"))
			checkerr(err)
			//保存已经进来的用户
			if !inArray(sUid,readyUid)  {
				readyUid = append(readyUid,sUid)
			}
			fmt.Println(readyUid)
			fmt.Printf("长度%d",len(readyUid))

			if  len(readyUid) ==3 {   //为每个用户分牌
				talkChan[100] <- getPeople(100) + " 您的手牌为：" + implodeArr(a)
				talkChan[101] <- getPeople(101) + " 您的手牌为：" + implodeArr(b)
				_, err := conn.Write([]byte(getPeople(102) + " 您的手牌为：" + implodeArr(c)))
				checkerr(err)
			}
			break
		}
	}
	//当前所有的连接
	fmt.Println("当前所有的连接",talkChan)
	//读取客户端传过来的数据
	go func() {
		for {
			data := make([]byte,1024)
			lines,err := conn.Read(data)
			if err != nil {
				fmt.Println("记录出错信息: ", err)
				closed <- true
				return
			}
			clientString := string(data[0:lines])
			fmt.Println("读取用户"+strconv.Itoa(curUid)+"数据为"+clientString)
			if clientString !="" {
				//判断谁出的 以及能不能出 以及下一个是谁出
				//将客户端过来的数据，写到相应的chan里
				if nextOut==102 && curUid==102 {
					if clientString ==  "0" {
						for i,_:= range talkChan{
							talkChan[i] <- getPeople(curUid) + "要不起"
						}
						//下一个出牌的是农民1
						nextOut = 100
						talkChan[102] <- getPeople(102) + " 您的剩余手牌为：" + implodeArr(c)
						talkChan[100] <- getPeople(100) + " 还剩：" + strconv.Itoa(len(a))
						talkChan[101] <- getPeople(101) + " 还剩：" + strconv.Itoa(len(b))
					}else {
						//判断出牌是不是对的
						outb,outarr := remainPuke(c,clientString)
						if outb {
							if IfTypeRight(clientString) {
								for i,_:= range talkChan{
									talkChan[i] <- getPeople(curUid) + "出的牌为" + clientString
								}
								//下一个出牌的是农民1
								nextOut = 100
								c = outarr
								talkChan[102] <- getPeople(102) + " 您的剩余手牌为：" + implodeArr(c)
								talkChan[100] <- getPeople(100) + " 还剩：" + strconv.Itoa(len(a))
								talkChan[101] <- getPeople(101) + " 还剩：" + strconv.Itoa(len(b))
								if len(c) == 0 {   //游戏结束
									for i,_:= range talkChan{
										talkChan[i] <- getPeople(curUid) + "出牌出完了，游戏结束，地主赢了！"
									}
								}
							}
						}
					}
				}
				if nextOut == 100  && curUid==100{
					if clientString ==  "0" {
						for i,_:= range talkChan{
							talkChan[i] <- getPeople(curUid) + "要不起"
						}
						//下一个出牌的是农民2
						nextOut = 101
						talkChan[100] <- getPeople(100) + " 您的剩余手牌为：" + implodeArr(a)
						talkChan[102] <- getPeople(102) + " 还剩：" + strconv.Itoa(len(c))
						talkChan[101] <- getPeople(101) + " 还剩：" + strconv.Itoa(len(b))
					}else {
						//判断出牌是不是对的
						outb,outarr := remainPuke(a,clientString)
						if outb {
							if IfTypeRight(clientString) {
								for i,_:= range talkChan{
									talkChan[i] <- getPeople(curUid) + "出的牌为" + clientString
								}
								//下一个出牌的是农民2
								nextOut = 101
								a = outarr
								talkChan[100] <- getPeople(100) + " 您的剩余手牌为：" + implodeArr(a)
								talkChan[102] <- getPeople(102) + " 还剩：" + strconv.Itoa(len(c))
								talkChan[101] <- getPeople(101) + " 还剩：" + strconv.Itoa(len(b))
								if len(a) == 0 {   //游戏结束
									for i,_:= range talkChan{
										talkChan[i] <- getPeople(curUid) + "出牌出完了，游戏结束，农民赢了！"
									}
								}
							}
						}
					}
				}
				if nextOut == 101  && curUid==101{
					if clientString ==  "0" {
						for i,_:= range talkChan{
							talkChan[i] <- getPeople(curUid) + "要不起"
						}
						//下一个出牌的是地主
						nextOut = 102
						talkChan[101] <- getPeople(101) + " 您的剩余手牌为：" + implodeArr(b)
						talkChan[102] <- getPeople(102) + " 还剩：" + strconv.Itoa(len(c))
						talkChan[100] <- getPeople(100) + " 还剩：" + strconv.Itoa(len(a))
					}else {
						//判断出牌是不是对的
						outb,outarr := remainPuke(b,clientString)
						if outb {
							if IfTypeRight(clientString) {
								for i,_:= range talkChan{
									talkChan[i] <- getPeople(curUid) + "出的牌为" + clientString
								}
								//下一个出牌的是地主
								nextOut = 102
								b = outarr
								talkChan[101] <- getPeople(101) + " 您的剩余手牌为：" + implodeArr(b)
								talkChan[102] <- getPeople(102) + " 还剩：" + strconv.Itoa(len(c))
								talkChan[100] <- getPeople(100) + " 还剩：" + strconv.Itoa(len(a))
								if len(b) == 0 {   //游戏结束
									for i,_:= range talkChan{
										talkChan[i] <- getPeople(curUid) + "出牌出完了，游戏结束，农民赢了！"
									}
								}
							}
						}
					}
				}
			}
		}
	}()

	go func() {
		for {
			talkString := <-talkChan[curUid]
			fmt.Println(talkString)
			_, err := conn.Write([]byte(talkString))
			if err != nil {
				closed <- true
				return
			}
		}
	}()

//检查是否已经关闭连接 如果关闭则推出该线程  去执行defer语句
	for {
		if <-closed {
			return
		}
	}
}

//剩余手牌 arg1表示之前的slice ，arg2 表示打出来的牌 [第一个返回值 代表能打出来]
func remainPuke(pre []string,str string)  (bool,[]string){
	arr := explodeStr(str)
	for _,v := range arr {
		b,index := indexInArray(v,pre)
		if !b {
			return false,arr
		}else {
			//删除切片
			pre=append(pre[:index],pre[index+1:]...)
		}
	}
	return true,pre
}
//是否存在slice中，多返回一个指数
func indexInArray(val string,arr []string) (bool,int){
	for i,v := range arr {
		if val == v {
			return true,i
		}
	}
	return false,-1
}


//获取用户身份
func getPeople(curUid int)  string{
	if curUid == 100 {
		return "农民1"
	}else if curUid == 101{
		return "农民2"
	}else {
		return "地主"
	}
}

//判断是不是单张牌
func isOneCard(str string) bool{
	if len(explodeStr(str)) == 1 {
		return true
	}
	return false
}
//判断是不是对子 返回是bool，同时返回主的那个值
func isTwoCards(str string) (b bool,val string){
	arr := explodeStr(str)
	if len(arr) == 2 {
		if arr[0] == arr[1] {
			return true,arr[0]
		}
	}
	return false,""
}
//判断是不是3带1  返回是bool，同时返回主的那个值
func isThreeCards(str string)  (b bool,val string){
	arr := explodeStr(str)
	if len(arr) != 4 {
		return false,""
	}
	tmp := make([]string,0)
	hasRepeat := false
	num := 0
	repeat := ""
	for _,v := range arr {
		if !inArray(v,tmp) {
			tmp = append(tmp,v)
		}else{   //如果有代表是重复值
			hasRepeat = true
			num +=1
			repeat = v
		}
	}
	if hasRepeat== true && num==3 {
		return true,repeat
	} else {
		return false,""
	}
}
//判断是不是姊妹对 返回 bool 和 姊妹对的最小数和最大数 和长度
func isSiblings(str string)  (b bool,min,max string,width int){
	arr := explodeStr(str)
	if len(arr) < 6 && len(arr) % 2 !=0 {
		return false,"","",0
	}
	var imin,imax int
	var tmp = make([]string,0)
	for i,v := range arr {
		if !ArrHasN(v,arr,2){      //一旦有一个不符合里面是两次的，那么就说明不对
			return false,"","",0
		}
		if pukeHash(v) == 15 || pukeHash(v) == 16 || pukeHash(v) == 17 {   //一旦姊妹对里出现了 2或者大小王，那么就不对
			return false,"","",0
		}
		if !inArray(strconv.Itoa(pukeHash(v)),tmp) {     //把所有唯一数存起来
			tmp = append(tmp , strconv.Itoa(pukeHash(v)))
		}
		if i==0 {      //第一次附初始值
			imin = pukeHash(v)
			imax = pukeHash(v)
		} else {       //第2次以后开始比较
			if pukeHash(v) > imax {
				imax = pukeHash(v)
			}
			if pukeHash(v) < imax {
				imin = pukeHash(v)
			}
		}
	}
	if !isConsecutive(tmp) {
		return false,"","",0
	} else {
		return true,rPukeHash(imin),rPukeHash(imax),len(tmp)
	}
}
//判断是不是飞机   返回是bool，同时返回主的那个值的最小值和最大值 和 长度
func isFlight(str string) (b bool,min,max string,width int) {
	arr := explodeStr(str)
	if len(arr) < 8 && len(arr) % 4 !=0 {
		return false,"","",0
	}
	var tmp = make([]string,0)      //飞机的主
	var tmp2 = make([]string,0)    //记录飞机的带子
	var imin,imax int
	for i,v := range arr {
		if pukeHash(v) == 15 || pukeHash(v) == 16 || pukeHash(v) == 17 {   //一旦姊妹对里出现了 2或者大小王，那么就不对
			return false,"","",0
		}
		if ArrHasN(v,arr,1) ||  ArrHasN(v,arr,2) {      //如果是出现一次【则是飞机里的带子】
			tmp2 = append(tmp2 , strconv.Itoa(pukeHash(v)))    //保存带子 【可以重的 所以直接追加】
		} else if ArrHasN(v,arr,3) {    //如果是出现三次【则是飞机里的带】
			if !inArray(strconv.Itoa(pukeHash(v)),tmp) {
				tmp = append(tmp , strconv.Itoa(pukeHash(v)))   //保存主
			}
			if i==0 {      //第一次附初始值
				imin = pukeHash(v)
				imax = pukeHash(v)
			} else {       //第2次以后开始比较
				if pukeHash(v) > imax {
					imax = pukeHash(v)
				}
				if pukeHash(v) < imax {
					imin = pukeHash(v)
				}
			}
		}else {
			return false,"","",0
		}
	}
	if len(tmp) != len(tmp2) {
		return false,"","",0
	}
	sort.Strings(tmp)   //对飞机的主排序
	if !isConsecutive(tmp) {
		return false,"","",0
	} else {
		return true,rPukeHash(imin),rPukeHash(imax),len(tmp)
	}
}

//判断是不是炸弹[除开王炸]   返回bool和该值
func isBoom(str string)  (b bool,val string){
	arr := explodeStr(str)
	var tmp = make([]string,0)      //句子临时slice 判断是不是唯一
	if len(arr) != 4 {
		return false,""
	}else {
		for _,v := range arr {
			if pukeHash(v) == 16 || pukeHash(v) == 17 {   //一旦句子出现了大小王，那么肯定不是炸弹
				return false,""
			}
			if !inArray(strconv.Itoa(pukeHash(v)),tmp) {
				val = v
				tmp = append(tmp , strconv.Itoa(pukeHash(v)))   //保存主
			}else{
				return false,""   //出现重复值 肯定不对
			}
		}
	}
	return true,val
}

//判断是不是王炸
func isBigBoom(str string)  (b bool){
	arr := explodeStr(str)
	var tmp string
	if len(arr) != 2 {
		return false
	}
	for i,v := range arr {
		if pukeHash(v) != 16  &&  pukeHash(v) != 17 {   //如果既不是小王也不是大王
			return false
		}
		if i== 0 {
			tmp = v
		}else {
			if v == tmp {      //第二次不可能是同一个值
				return false
			}
		}
	}
	return true
}

//判断是不是句子（顺子）  //返回是bool，同时返回主的那个值的最小值和最大值 和 长度
func isWords(str string)  (b bool,min,max string,width int) {
	arr := explodeStr(str)
	var tmp = make([]string,0)      //句子临时slice 判断是不是唯一
	var imin,imax int
	if len(arr) < 5 && len(arr) > 12 {   //句子就这么长
		return false,"","",0
	}
	for i,v := range arr {
		if pukeHash(v) == 15 || pukeHash(v) == 16 || pukeHash(v) == 17 {   //一旦句子出现了 2或者大小王，那么就不对
			return false,"","",0
		}
		if !inArray(strconv.Itoa(pukeHash(v)),tmp) {
			tmp = append(tmp , strconv.Itoa(pukeHash(v)))   //保存主
		}else{
			return false,"","",0    //出现重复值 肯定不对
		}
		if i==0 {      //第一次附初始值
			imin = pukeHash(v)
			imax = pukeHash(v)
		} else {       //第2次以后开始比较
			if pukeHash(v) > imax {
				imax = pukeHash(v)
			}
			if pukeHash(v) < imax {
				imin = pukeHash(v)
			}
		}
	}

	sort.Strings(tmp)   //对飞机的主排序
	if !isConsecutive(tmp) {
		return false,"","",0
	} else {
		return true,rPukeHash(imin),rPukeHash(imax),len(tmp)
	}
}


//是不是连续的
func isConsecutive(arr []string)  bool{
	sort.Strings(arr)
	var a int
	for i,v := range arr {
		res,err := strconv.Atoi(v)
		if err != nil {
			return false
		} else {
			if i == 0 {
				a = res
			}else {
				if res != a+1 {
					return false
				}
			}
		}
	}
	return true
}

func checkerr(err error)  {
	if err != nil {
		fmt.Println( err)
	}
}


