<?php
/* 每日待收金额(存管)处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
$time1 = $_POST[0];
$time2  = $_POST[1];
if($time1==$time2){
	$query = "select * from daily_repay_money_deal_loan_cg where date = \"$time1\"";
}else{
	$query = "select * from daily_repay_money_deal_loan_cg where date >= \"$time1\" and date <= \"$time2\"";
}


$result = mysqli_query($link, $query);

$arr = $result->fetch_all(MYSQLI_ASSOC);

mysqli_close($link);
for($i=0;$i<count($arr);$i++){
	
	$arr[$i]['deal_self_money'] = number_format((($arr[$i]['deal_self_money'])/10000),2,'.','');
	$arr[$i]['deal_interest_money'] = number_format((($arr[$i]['deal_interest_money'])/10000),2,'.','');
	$arr[$i]['deal_manage_money'] = number_format((($arr[$i]['deal_manage_money'])/10000),2,'.','');
	$arr[$i]['deal_manage_impose_money'] = number_format((($arr[$i]['deal_manage_impose_money'])/10000),2,'.','');
	$arr[$i]['loan_self_money'] = number_format((($arr[$i]['loan_self_money'])/10000),2,'.','');
	$arr[$i]['loan_interest_money'] = number_format((($arr[$i]['loan_interest_money'])/10000),2,'.','');
}
echo  json_encode($arr);