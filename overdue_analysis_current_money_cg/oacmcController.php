<?php
/* 金额-现状版表格图处理数据文件(存管)
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
$field = $_POST[1];
$date  = $_POST[0];
$query = "select * from overdue_analysis_current_money_cg where field = \"$field\" and status_time= \"$date\"";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
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
for($i=0;$i<count($arr);$i++){
	if($arr[$i]['field_value']==''){
		$arr[$i]['field_value']='不详';
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
if($field=="期数"){
	sort($arr);
}
echo  json_encode($arr);
