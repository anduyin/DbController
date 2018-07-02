<?php
require_once 'PHPExcel-1.8/Classes/xls1.php';
$date  = $_POST['date'];
$tmp = $_POST['tmp'];
$name = substr($tmp,0,1);
require_once 'Common.php';
if($name == "D"){
	$Xlsname = "应收账款数据表(存管)";
	$query = "select * from data_accounts_receivable_cg where status_time=\"$date\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		$arr[$i]['total_amount']=number_format((($arr[$i]['total_amount'])/10000),2,'.','');
		$arr[$i]['ture_total_amount']=number_format((($arr[$i]['ture_total_amount'])/10000),2,'.','');
		$arr[$i]['Advance_money']=number_format((($arr[$i]['Advance_money'])/10000),2,'.','');
		$arr[$i]['advance_payment_1']=number_format((($arr[$i]['advance_payment_1'])/10000),2,'.','');
		$arr[$i]['advance_payment_30']=number_format((($arr[$i]['advance_payment_30'])/10000),2,'.','');
		$arr[$i]['advance_payment_60']=number_format((($arr[$i]['advance_payment_60'])/10000),2,'.','');
		$arr[$i]['advance_payment_90']=number_format((($arr[$i]['advance_payment_90'])/10000),2,'.','');
		unset($arr[$i]['status_time']);
	}
	foreach($arr as $v){
		$brr = $v;
	}
	$key = array_keys($brr);
}elseif($name == "F"){
	$Xlsname = "利息金额表(存管)";
	$query =  "select * from data_amount_to_be_collected_cg where status_time=\"$date\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		$arr[$i]['repay_money']=number_format((($arr[$i]['repay_money'])/10000),2,'.','');
		$arr[$i]['self_money']=number_format((($arr[$i]['self_money'])/10000),2,'.','');
		$arr[$i]['interest_money']=number_format((($arr[$i]['interest_money'])/10000),2,'.','');
		$arr[$i]['M0']=number_format((($arr[$i]['M0'])/10000),2,'.','');
		$arr[$i]['M1']=number_format((($arr[$i]['M1'])/10000),2,'.','');
		$arr[$i]['M2']=number_format((($arr[$i]['M2'])/10000),2,'.','');
		$arr[$i]['M3']=number_format((($arr[$i]['M3'])/10000),2,'.','');
		$arr[$i]['M4']=number_format((($arr[$i]['M4'])/10000),2,'.','');
		$arr[$i]['M5']=number_format((($arr[$i]['M5'])/10000),2,'.','');
		$arr[$i]['M6']=number_format((($arr[$i]['M6'])/10000),2,'.','');
		$arr[$i]['M7']=number_format((($arr[$i]['M7'])/10000),2,'.','');
		$arr[$i]['M8']=number_format((($arr[$i]['M8'])/10000),2,'.','');
		$arr[$i]['M9']=number_format((($arr[$i]['M9'])/10000),2,'.','');
		$arr[$i]['M10']=number_format((($arr[$i]['M10'])/10000),2,'.','');
		$arr[$i]['M11']=number_format((($arr[$i]['M11'])/10000),2,'.','');
		$arr[$i]['M12']=number_format((($arr[$i]['M12'])/10000),2,'.','');
		unset($arr[$i]['status_time']);
	}
	foreach($arr as $v){
		$brr = $v;
	}
	$key = array_keys($brr);
}elseif($name == "K"){
	$Xlsname = "垫付数据图(存管)";
	$query = "select * from data_details_should_be_mat_cg where status_time=\"$date\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		$arr[$i]['advance_payment']=number_format((($arr[$i]['advance_payment'])/10000),2,'.','');
		$arr[$i]['ture_advance_payment']=number_format((($arr[$i]['ture_advance_payment'])/10000),2,'.','');
		$arr[$i]['not_advance_payment']=number_format((($arr[$i]['not_advance_payment'])/10000),2,'.','');
		unset($arr[$i]['status_time']);
	}
	foreach($arr as $v){
		$brr = $v;
	}
	$key = array_keys($brr);
}
//var_dump($arr);exit;
exportExcel($arr,$Xlsname,$key,$tmp);