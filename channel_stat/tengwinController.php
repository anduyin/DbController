<?php
require_once '../Common.php';
require_once '../main.php';
//查询(总额)
function searchTotal($link){

    $main = new main();
    $where = [];
    $serial_num = $_POST['serial_num'];
    $electrical_name = $_POST['electrical_name'];
    $status = $_POST['status'];
    $service_center_name = $_POST['service_center_name'];
    $group_name = $_POST['group_name'];
    $customer_user = $_POST['customer_user'];
    $transfer_user = $_POST['transfer_user'];
    $agent_name = $_POST['agent_name'];
    $channel_name = $_POST['channel_name'];
    $pay_time_start = $_POST['pay_time_start'];
    $pay_time_end = $_POST['pay_time_end'];
    $registration_time_start = $_POST['registration_time_start'];
    $registration_time_end = $_POST['registration_time_end'];
    $trueWhere = '';
    if($serial_num){
        $where['serial_num ='] = $serial_num;
    }
    if($electrical_name){
        $where['electrical_name =']= "\"".$electrical_name."\"";
    }

    if($status!="-1"){
        if($status=="1"){
            $where['status ='] = "'已支付'";
        }else{
            $where['status = '] = "'未支付'";
        }
    }
    if($service_center_name!="-1"){
        $where["service_center_name = "] = "\"".$service_center_name."\"";
    }
    if($group_name!="-1"){
        $where["group_name = "] = "\"".$group_name."\"";
    }
    if($customer_user){
        $where["customer_user = "]= "\"".$customer_user."\"";
    }
    if($transfer_user){
        $where["transfer_user = "] = "\"".$transfer_user."\"";
    }
    if($agent_name){
        $where["agent_name = "]= "\"".$agent_name."\"";
    }
    if($channel_name){
        $where["channel_name = "] = "\"".$channel_name."\"";
    }
    if($pay_time_start && $pay_time_end){
        $where['pay_time >= '] = "\"".$pay_time_start."\"";
        $where["pay_time <= "] = "\"".$pay_time_end."\"";
    }
    if($registration_time_start && $registration_time_end){
        $where['pay_time >= '] = "\"".$registration_time_start."\"";
        $where["pay_time <= "] = "\"".$registration_time_end."\"";
    }
    $maxNum = count($where);
    $numWhere = 0;
    foreach($where as $k=>$v){
        $numWhere++;
        if($maxNum == $numWhere){
            $trueWhere .= $k.$v;
        }else{
            $trueWhere .= $k.$v.' AND ';
        }
    }
    if($maxNum){
        $trueWhere = " WHERE ".$trueWhere;
    }
    $page = $_POST['page'];
    $pageSize = $_POST['pageSize'];
    $index= ($page-1)*$pageSize;
    $limit = ' limit '.$index.','.$pageSize;
    $field = $main->getColumnName($link,'tengwin_service_application');
    $query = "select {$field} from `tengwin_service_application` {$trueWhere} ORDER BY registration_time DESC {$limit}";
    $result = mysqli_query($link, $query);
    $arr = $result->fetch_all(MYSQLI_ASSOC);
    //求总页数
    $totalSql = "select count('*') from `tengwin_service_application` {$trueWhere} ORDER BY registration_time DESC ";
    $totalRe = mysqli_query($link,$totalSql);
    $num = $totalRe->fetch_row();
    $max = ceil($num[0]/$pageSize);
    //计算总服务金额
    $total_sql = "SELECT COALESCE(sum(amount),0) as total FROM `tengwin_service_application` {$trueWhere} ORDER BY registration_time DESC";
    $result_total = mysqli_query($link, $total_sql);
    $totalMoney = $result_total->fetch_assoc();
    mysqli_close($link);
    $json['page'] = $page;
    $json['data'] = $arr;
    $json['max'] = $max;
    $json['totalMoney'] = $totalMoney['total'];
    echo  json_encode($json);
}

function searchGradient($link){
    $where = [];
    $create_date_start = $_POST['create_date_start'];
    $create_date_end = $_POST['create_date_end'];
    $gradient = $_POST['gradient'];
    $trueWhere = '';
    if($gradient!='-1'){
        $where['gradient ='] = $gradient;
    }

    if($create_date_start && $create_date_end){
        $where['create_date >= '] = "\"".$create_date_start."\"";
        $where["create_date <= "] = "\"".$create_date_end."\"";
    }

    $maxNum = count($where);
    $numWhere = 0;
    foreach($where as $k=>$v){
        $numWhere++;
        if($maxNum == $numWhere){
            $trueWhere .= $k.$v;
        }else{
            $trueWhere .= $k.$v.' AND ';
        }
    }
    if($maxNum){
        $trueWhere = " WHERE ".$trueWhere;
    }
    //求分配梯度统计(数量版)
    $field_num = "create_date,assignment,follow,deal,follow_deal,pay,front_end_income,back_end_income";
    $query = "select {$field_num} from `tenwin_assign_gradient_statistics` {$trueWhere} ORDER BY create_date DESC ";
    $result = mysqli_query($link, $query);
    $arr_num = $result->fetch_all(MYSQLI_ASSOC);
    //分配梯度统计(百分比版)
    $field_per = "create_date,follow_rate,deal_rate,follow_deal_rate,pay_rate";
    $query = "select {$field_per} from `tenwin_assign_gradient_statistics` {$trueWhere} ORDER BY create_date DESC ";
    $result = mysqli_query($link, $query);
    $arr_per = $result->fetch_all(MYSQLI_ASSOC);
    mysqli_close($link);
    $json['dataNum'] = $arr_num;
    $json['dataPer'] = $arr_per;
    echo  json_encode($json);
}

if($_POST&&$_POST['code']=='tengwin_service_application') {
    searchTotal($link);
}elseif($_POST&&$_POST['code']=='tenwin_assign_gradient_statistics'){
    searchGradient($link);
}


