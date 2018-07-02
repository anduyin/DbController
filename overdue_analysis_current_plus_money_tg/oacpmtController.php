<?php
/* 金额-现状版表格图处理数据文件 逾期分析
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
$field = $_POST[1];
$loan_name  = $_POST[0];
$time = $_POST[2];
$query = "select * from overdue_analysis_current_plus_money_tg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
if($field =='还款压力'&&$loan_name=='总计'){
	$c = $arr[2];
	$arr[2] = $arr[3];
	$arr[3] = $arr[4];
	$arr[4] = $arr[5];
	$arr[5] = $c;
	
}
for($i=0;$i<count($arr);$i++){
	
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
	$arr[$i]['放款金额占比'] = number_format((($arr[$i]['放款金额占比'])*100),2,'.','');
}

echo  json_encode($arr);
