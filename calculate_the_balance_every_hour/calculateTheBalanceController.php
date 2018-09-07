<?php
/* 存管余额数据表
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';

//查询
function searchTotal($link){
    $where = [];
    $page = $_POST['page'];
    $pageSize = $_POST['pageSize'];
    $index= ($page-1)*$pageSize;
    $limit = ' limit '.$index.','.$pageSize;
    $field = "startdate,enddate,cost,type,balance";
    $query = "select ".$field." from `calculate_the_balance_every_hour` order by startdate desc ".$limit;
    $result = mysqli_query($link, $query);
    $arr = $result->fetch_all(MYSQLI_ASSOC);
    foreach($arr as $key=>$value){
        $arr[$key]['type'] = $value['type'] == '0'?$value['type'] = '扣费':$value['type'] = '充值';
    }
    //求总页数
    $totalSql = "select count(*) from `calculate_the_balance_every_hour`";
    $totalRe = mysqli_query($link,$totalSql);
    $num = $totalRe->fetch_row();
    $max = ceil($num[0]/$pageSize);
    mysqli_close($link);
    $json['page'] = $page;
    $json['data'] = $arr;
    $json['max'] = $max;
    echo  json_encode($json);
}

function arrayMain($data){
    $array = array();
    foreach($data as $v){
        @$array[0] += $v['num'];
        @$array[1] += $v['loan'];
        @$array[2] += $v['service_fee'];
        $array[3] = $v['Loan_type'];
        $array[4] = $v['loan_time'];
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
//充值插入数据
function recharge($link,$AuthorizationCode){
    $pwd = $_POST['password'];
    if($pwd != $AuthorizationCode){
        $json['code'] =100;
        $json['message'] = '授权密码输入错误!';
        echo json_encode($json);
        return;
    }
    $cost = $_POST['cost'];
    $balance = $_POST['balance'];
    if(!preg_match('/^(?:0|\-?(?:0\.\d*[1-9]|[1-9]\d*(?:\.\d*[1-9])?))$/',$cost)){
        $json['code'] = 100;
        $json['message'] = "请输入正确的充值金额";
        echo json_encode($json);
        return;
    }
    if(!preg_match('/^(?:0|\-?(?:0\.\d*[1-9]|[1-9]\d*(?:\.\d*[1-9])?))$/',$balance)){
        $json['code'] = 100;
        $json['message'] = "请输入正确的余额";
        echo json_encode($json);
        return;
    }
    $page = $_POST['page'];
    $pageSize = $_POST['pageSize'];
    $index= ($page-1)*$pageSize;
    $limit = ' limit '.$index.','.$pageSize;
    $time = "\"".date('Y-m-d H:i:s',time())."\"";
    $type = 1;
    $query = "INSERT INTO `calculate_the_balance_every_hour`(startdate,enddate,cost,type,balance) VALUES({$time},{$time},{$cost},{$type},{$balance})";
    $re = mysqli_query($link, $query);
    if($re){
        $field = "startdate,enddate,cost,type,balance";
        $query = "select ".$field." from `calculate_the_balance_every_hour` order by startdate desc ".$limit;
        $result = mysqli_query($link, $query);
        $arr = $result->fetch_all(MYSQLI_ASSOC);
        foreach($arr as $key=>$value){
            $arr[$key]['type'] = $value['type'] == '0'?$value['type'] = '扣费':$value['type'] = '充值';
        }
        //求总页数
        $totalSql = "select count(*) from `calculate_the_balance_every_hour`";
        $totalRe = mysqli_query($link,$totalSql);
        $num = $totalRe->fetch_row();
        $max = ceil($num[0]/$pageSize);
        mysqli_close($link);
        $json['message'] = '插入成功';
        $json['page'] = $page;
        $json['data'] = $arr;
        $json['max'] = $max;
        echo  json_encode($json);
    }
}


if($_POST&&$_POST['code']=='searchTotal') {
    searchTotal($link);
}elseif($_POST&&$_POST['code']=='recharge'){
    recharge($link,$AuthorizationCode);
}
