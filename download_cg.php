<?php
//表格下载处理脚本(存管风控数据专用)
require_once 'PHPExcel-1.8/Classes/xls1.php';
@$field = $_POST['field'];
@$date  = $_POST['date'];
$tmp = $_POST['tmp'];
$name = substr($tmp,0,1);
require_once 'Common.php';

if($name == "O"){
	$Xlsname = "金额-回溯版(存管)";
	$query = "select * from overdue_analysis_track_money_cg where field = \"$field\" and status_time= \"$date\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		if($arr[$i]['field_value']==''){
			$arr[$i]['field_value']='不祥';
		}
		$arr[$i]['repaymoney']=number_format((($arr[$i]['repaymoney'])/10000),2,'.','');
		$arr[$i]['shouldmoney']=number_format((($arr[$i]['shouldmoney'])/10000),2,'.','');
		$arr[$i]['prepay_ratio'] = number_format((($arr[$i]['prepay_ratio'])*100),2,'.','');
		$arr[$i]['onday_ratio'] = number_format((($arr[$i]['onday_ratio'])*100),2,'.','');
		$arr[$i]['T+1overdue_ratio'] = number_format((($arr[$i]['T+1overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+2overdue_ratio'] = number_format((($arr[$i]['T+2overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+3overdue_ratio'] = number_format((($arr[$i]['T+3overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+4overdue_ratio'] = number_format((($arr[$i]['T+4overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+5overdue_ratio'] = number_format((($arr[$i]['T+5overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+6overdue_ratio'] = number_format((($arr[$i]['T+6overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+7overdue_ratio'] = number_format((($arr[$i]['T+7overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+31overdue_ratio'] = number_format((($arr[$i]['T+31overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+61overdue_ratio'] = number_format((($arr[$i]['T+61overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+91overdue_ratio'] = number_format((($arr[$i]['T+91overdue_ratio'])*100),2,'.','');
		$arr[$i]['repaymoney_proportion'] = number_format((($arr[$i]['repaymoney_proportion'])*100),2,'.','');
	}
}elseif($name == "N"){
	$Xlsname = "笔数-回溯版(存管)";
	$query = "select * from overdue_analysis_track_num_cg where field = \"$field\" and status_time= \"$date\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	
	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		if($arr[$i]['field_value']==''){
			$arr[$i]['field_value']='不祥';
		}
		$arr[$i]['prepay_ratio'] = number_format((($arr[$i]['prepay_ratio'])*100),2,'.','');
		$arr[$i]['onday_ratio'] = number_format((($arr[$i]['onday_ratio'])*100),2,'.','');
		$arr[$i]['T+1overdue_ratio'] = number_format((($arr[$i]['T+1overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+2overdue_ratio'] = number_format((($arr[$i]['T+2overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+3overdue_ratio'] = number_format((($arr[$i]['T+3overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+4overdue_ratio'] = number_format((($arr[$i]['T+4overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+5overdue_ratio'] = number_format((($arr[$i]['T+5overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+6overdue_ratio'] = number_format((($arr[$i]['T+6overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+7overdue_ratio'] = number_format((($arr[$i]['T+7overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+31overdue_ratio'] = number_format((($arr[$i]['T+31overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+61overdue_ratio'] = number_format((($arr[$i]['T+61overdue_ratio'])*100),2,'.','');
		$arr[$i]['T+91overdue_ratio'] = number_format((($arr[$i]['T+91overdue_ratio'])*100),2,'.','');
		$arr[$i]['count_proportion'] = number_format((($arr[$i]['count_proportion'])*100),2,'.','');
	}
}elseif($name == "A"){
	$Xlsname = "金额-现状版(存管)";
	$query = "select * from overdue_analysis_current_money_cg where field = \"$field\" and status_time= \"$date\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		if($arr[$i]['field_value']==''){
			$arr[$i]['field_value']='不祥';
		}
		$arr[$i]['borrow_selfmoney'] = number_format((($arr[$i]['borrow_selfmoney'])/10000),2,'.','');
		$arr[$i]['loaning_selfmoney'] = number_format((($arr[$i]['loaning_selfmoney'])/10000),2,'.','');
		$arr[$i]['should_selfmoney'] = number_format((($arr[$i]['should_selfmoney'])/10000),2,'.','');
		$arr[$i]['overdue_selfmoney'] = number_format((($arr[$i]['overdue_selfmoney'])/10000),2,'.','');
		$arr[$i]['Totaloverdue_ratio'] = number_format((($arr[$i]['Totaloverdue_ratio'])*100),2,'.','');
		$arr[$i]['M1selfmoney'] = number_format((($arr[$i]['M1selfmoney'])/10000),2,'.','');
		$arr[$i]['M1overdue_ratio'] = number_format((($arr[$i]['M1overdue_ratio'])*100),2,'.','');
		$arr[$i]['M2selfmoney'] = number_format((($arr[$i]['M2selfmoney'])/10000),2,'.','');
		$arr[$i]['M2overdue_ratio'] = number_format((($arr[$i]['M2overdue_ratio'])*100),2,'.','');
		$arr[$i]['M3selfmoney'] = number_format((($arr[$i]['M3selfmoney'])/10000),2,'.','');
		$arr[$i]['M3overdue_ratio'] = number_format((($arr[$i]['M3overdue_ratio'])*100),2,'.','');
		$arr[$i]['Morethan_M4selfmoney'] = number_format((($arr[$i]['Morethan_M4selfmoney'])/10000),2,'.','');
		$arr[$i]['Morethan_M4overdue_ratio'] = number_format((($arr[$i]['Morethan_M4overdue_ratio'])*100),2,'.','');
	}
}elseif($name == "B"){
	
	$Xlsname = "笔数-现状版(存管)";
	$query = "select * from overdue_analysis_current_num_cg where field = \"$field\" and status_time= \"$date\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		if($arr[$i]['field_value']==''){
			$arr[$i]['field_value']='不祥';
		}
		$arr[$i]['Totaloverdue_ratio'] = number_format((($arr[$i]['Totaloverdue_ratio'])*100),2,'.','');	
	$arr[$i]['M1overdue_ratio'] = number_format((($arr[$i]['M1overdue_ratio'])*100),2,'.','');
	$arr[$i]['M2overdue_ratio'] = number_format((($arr[$i]['M2overdue_ratio'])*100),2,'.','');
	$arr[$i]['M3overdue_ratio'] = number_format((($arr[$i]['M3overdue_ratio'])*100),2,'.','');
	$arr[$i]['Morethan_M4overdue_ratio'] = number_format((($arr[$i]['Morethan_M4overdue_ratio'])*100),2,'.','');
	}
}elseif($name == "C"){
	$Xlsname = "每日待收金额(存管)";
	
	$query = "select id,date as '截止日期',deal_self_money as '待还本金(万元)',deal_interest_money as '待还利息(万元)',deal_manage_money as '待还管理费(万元)',deal_manage_impose_money as '待还逾期管理费(万元)',loan_self_money as '待收本金(万元)',loan_interest_money as '待收利息(万元)' from daily_repay_money_deal_loan_cg";
	
	$result = mysqli_query($link, $query);

	$arr = $result->fetch_all(MYSQLI_ASSOC);

	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		$arr[$i]['id'] = $arr[$i]['id'];
		$arr[$i]['截止日期'] = $arr[$i]['截止日期'];
		$arr[$i]['待还本金(万元)'] = number_format((($arr[$i]['待还本金(万元)'])/10000),2,'.','');
		$arr[$i]['待还利息(万元)'] = number_format((($arr[$i]['待还利息(万元)'])/10000),2,'.','');
		$arr[$i]['待还管理费(万元)'] = number_format((($arr[$i]['待还管理费(万元)'])/10000),2,'.','');
		$arr[$i]['待还逾期管理费(万元)'] = number_format((($arr[$i]['待还逾期管理费(万元)'])/10000),2,'.','');
		$arr[$i]['待收本金(万元)'] = number_format((($arr[$i]['待收本金(万元)'])/10000),2,'.','');
		$arr[$i]['待收利息(万元)'] = number_format((($arr[$i]['待收利息(万元)'])/10000),2,'.','');
	}
}
/*if($field =='还款压力'){
	$c = array($arr[1],$arr[2]);
	$arr[1] = $arr[3];
	$arr[2] = $arr[4];
	$arr[3] = $arr[5];
	$arr[4] = $arr[6];
	$arr[5] = $arr[7];
	$arr[6] = $arr[8];
	$arr[7] = $c[0];
	$arr[8] = $c[1];
}*/
if($field=="期数"){
	sort($arr);
}
foreach($arr as $v){
	$brr = $v;
}
$key = array_keys($brr);

exportExcel($arr,$Xlsname,$key,$tmp);
