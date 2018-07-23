<?php
/* 存管接口调用服务费处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';

//查询(总额)
function searchTotal($link){
    $time1 = $_POST[0];
    $time2  = $_POST[1];
    $time = '';
    if($time1==$time2){
        $time = $time2;
        $query = "SELECT * FROM `ph_loan_salary` where status_time = \"$time1\"";
    }else{
        $time = $time1."~".$time2;
        $query = "SELECT * FROM `ph_loan_salary` where status_time >= \"$time1\" and status_time <= \"$time2\"";
    }
    $result = mysqli_query($link, $query);
    $arr = $result->fetch_all(MYSQLI_ASSOC);
    mysqli_close($link);
    $array = [];
    $total = [];
    foreach($arr as $v){
        @$total[0] += $v['num'];
        @$total[1] += $v['loan'];
        @$total[2] += $v['service_fee'];
    }
    $total[3] = $time;
    $array[] = $total;
    echo  json_encode($array);
}

function arrayMain($data){
    $array = array();
    foreach($data as $v){
        @$array[0] += $v['num'];
        @$array[1] += $v['loan'];
        @$array[2] += $v['service_fee'];
        $array[3] = $v['status_time'];
    }
    return $array;
}
/**
 * 获取某月第一天和最后一天
 * @param  [string] $date [日期]
 * @return [array]       [包含第一天和最后一天的日期]
 */
function getthemonth($date){
    $firstday = date('Y-m-01', strtotime($date));
    $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
    return array($firstday,$lastday);
}

if($_POST&&$_POST[2]=='search'){
    searchDate($link);
}elseif($_POST&&$_POST[2]=='money'){
    countMoney($link);
}elseif($_POST&&$_POST[2]=='searchTotal'){
    searchTotal($link);
}elseif($_POST&&$_POST[2]=='searchGroup'){
    searchGroup($link);
}elseif($_POST&&$_POST[2]=='searchDay'){
    searchDay($link);
}
