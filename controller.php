<?php
/* 表格图处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */
session_start();
 if($_SESSION['status']==0){
 	echo "您没有权限查看";
 	header("Location: Login.html");
}
require_once 'Common.php';
$field = $_POST[1];
$date  = $_POST[0];
$query = "select * from overdue_analysis_current where field = \"$field\" and status_time= \"$date\"";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
if($field =='还款压力'){
	$c = array($arr[1],$arr[2]);
	$arr[1] = $arr[3];
	$arr[2] = $arr[4];
	$arr[3] = $arr[5];
	$arr[4] = $arr[6];
	$arr[5] = $arr[7];
	$arr[6] = $arr[8];
	$arr[7] = $c[0];
	$arr[8] = $c[1];
}
for($i=0;$i<count($arr);$i++){
	if($arr[$i]['field_value']=="nan"){
		$arr[$i]['field_value']="不详";
	}
	$arr[$i]['M1money']=number_format((($arr[$i]['M1money'])/10000),2,'.','');
	$arr[$i]['M2money']=number_format((($arr[$i]['M2money'])/10000),2,'.','');
	$arr[$i]['M3money']=number_format((($arr[$i]['M3money'])/10000),2,'.','');
	$arr[$i]['should_money']=number_format((($arr[$i]['should_money'])/10000),2,'.','');
	$arr[$i]['M1overdue_ratio'] = number_format((($arr[$i]['M1overdue_ratio'])*100),2,'.','');
	$arr[$i]['M2overdue_ratio'] = number_format((($arr[$i]['M2overdue_ratio'])*100),2,'.','');
	$arr[$i]['M3overdue_ratio'] = number_format((($arr[$i]['M3overdue_ratio'])*100),2,'.','');
}
if($field=="期数"){
	sort($arr);
}
echo  json_encode($arr);
