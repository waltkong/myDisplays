package common

func JsonReply(status string,msg string)  Reply{
	reply := Reply{
		Status : status,
		Message :msg,
	}
	return reply
}