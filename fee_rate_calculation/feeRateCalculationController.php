<?php
/* 存管接口调用服务费处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';

//查询
function searchTotal($link){
    $where['name ='] = $_POST['name'] != -1?$_POST['name']:'';
    $where['bid_status ='] = $_POST['bid_status'] != -1?$_POST['bid_status']:'';
    $where['is_36 ='] = $_POST['is_36'] != -1?$_POST['is_36']:'';
    $where['loan_date >='] = $_POST['loan_date1'] != -1?$_POST['loan_date1']:'';
    $where['loan_date <='] = $_POST['loan_date2'] != -1?$_POST['loan_date2']:'';
    $where['repay_date >='] = $_POST['repay_date1'] != -1?$_POST['repay_date1']:'';
    $where['repay_date <='] = $_POST['repay_date2'] != -1?$_POST['repay_date2']:'';
    $page = $_POST['page'];
    $pageSize = $_POST['pageSize'];
    $index= ($page-1)*$pageSize;
    $limit = ' limit '.$index.','.$pageSize;
    $whereSql = '';
    if(!empty($where)&&is_array($where)){
        foreach($where as $k=>$v){
            if($v == ''){
                unset($where[$k]);
            }
        }
        $num = count($where);
        foreach($where as $key=>$value){
            if($num == 1){
                $whereSql = $key.'\''.$value.'\'';
            }else{
                $whereSql .= $key.'\''.$value.'\''.' and ';
            }
        }
        if($num!=1){
            $whereSql = substr_replace($whereSql,' ',-4,4);
        }
        $whereSql = 'where '.$whereSql;
    }
    if(empty($where)){
        $whereSql = '';
    }
    $query = "select * from `fee_rate_calculation`".$whereSql.$limit;
    $result = mysqli_query($link, $query);
    $arr = $result->fetch_all(MYSQLI_ASSOC);
    //求总页数
    $totalSql = "select count(*) from `fee_rate_calculation`".$whereSql;
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

if($_POST&&$_POST['code']=='searchTotal') {
    searchTotal($link);
}
