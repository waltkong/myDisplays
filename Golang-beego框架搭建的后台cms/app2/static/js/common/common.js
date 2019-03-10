function convertYMDToTimeStamp(str,startOrEnd) {
    if(str == ""){
        return "";
    }
    if(startOrEnd == 1){
        str += " " + "00:00:00:000";
    }else {
        str += " " + "23:59:59:000";
    }
    var date = new Date(str);   //'2014-04-23 18:55:49:123'
    var time = Date.parse(date);
    return time/1000;
}