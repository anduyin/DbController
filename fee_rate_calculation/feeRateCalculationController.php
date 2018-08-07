<?php
/* 存管接口调用服务费处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';

//查询
function searchTotal($link){
    $name = $_POST['name'] != -1?$_POST['name']:'';
    $bid_status = $_POST['bid_status'] != -1?$_POST['bid_status']:'';
    $is_36 = $_POST['is_36'] != -1?$_POST['is_36']:'';
    $loan_date1 = $_POST['loan_date1'] != -1?$_POST['loan_date1']:'';
    $loan_date2 = $_POST['loan_date2'] != -1?$_POST['loan_date2']:'';
    $repay_date1 = $_POST['repay_date1'] != -1?$_POST['repay_date1']:'';
    $repay_date2 = $_POST['repay_date2'] != -1?$_POST['repay_date2']:'';
    $page = $_POST['page'];
    $pageSize = $_POST['pageSize'];
    $index= ($page-1)*$pageSize;
    $limit = ' limit('.$index.','.$pageSize.')';
    $where = '';
    $query = "select * from `fee_rate_calculation`".$where.$limit;
    if($name||$bid_status||$is_36||$loan_date1||$loan_date2||$repay_date1||$repay_date2){
        $where = ' where ';

    }



    $result = mysqli_query($link, $query);
    $arr = $result->fetch_all(MYSQLI_ASSOC);
    mysqli_close($link);

    echo  json_encode($array);
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

if($_POST&&$_POST['code']=='searchTotal') {
    searchTotal($link);
}
