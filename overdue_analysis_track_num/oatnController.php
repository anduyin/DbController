<?php
/* 笔数-回溯版表格图处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php'; 
$field = $_POST[1];
$date  = $_POST[0];
$query = "select * from overdue_analysis_track_num_tg where field = \"$field\" and status_time= \"$date\"";
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
if($field=="期数"){
	sort($arr);
}
echo  json_encode($arr);