<?php
/* 笔数-现状版表格图处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
$field = $_POST[1];
$date  = $_POST[0];
$query = "select * from overdue_analysis_current_num_tg where field = \"$field\" and status_time= \"$date\"";
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
	$arr[$i]['Totaloverdue_ratio'] = number_format((($arr[$i]['Totaloverdue_ratio'])*100),2,'.','');	
	$arr[$i]['M1overdue_ratio'] = number_format((($arr[$i]['M1overdue_ratio'])*100),2,'.','');
	$arr[$i]['M2overdue_ratio'] = number_format((($arr[$i]['M2overdue_ratio'])*100),2,'.','');
	$arr[$i]['M3overdue_ratio'] = number_format((($arr[$i]['M3overdue_ratio'])*100),2,'.','');
	$arr[$i]['Morethan_M4overdue_ratio'] = number_format((($arr[$i]['Morethan_M4overdue_ratio'])*100),2,'.','');
}
if($field=="期数"){
	sort($arr);
}
echo  json_encode($arr);