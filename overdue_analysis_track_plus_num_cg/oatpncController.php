<?php
/* 笔数-回溯版表格图处理数据文件 逾期分析(存管)
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
$field = $_POST[1];
$loan_name  = $_POST[0];
$time = $_POST[2];
$query = "select * from overdue_analysis_track_plus_num_cg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
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
	
	
	$arr[$i]['T+1overdue_ratio'] = number_format((($arr[$i]['T+1overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+2overdue_ratio'] = number_format((($arr[$i]['T+2overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+31overdue_ratio'] = number_format((($arr[$i]['T+31overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+3overdue_ratio'] = number_format((($arr[$i]['T+3overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+4overdue_ratio'] = number_format((($arr[$i]['T+4overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+5overdue_ratio'] = number_format((($arr[$i]['T+5overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+61overdue_ratio'] = number_format((($arr[$i]['T+61overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+6overdue_ratio'] = number_format((($arr[$i]['T+6overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+7overdue_ratio'] = number_format((($arr[$i]['T+7overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+91overdue_ratio'] = number_format((($arr[$i]['T+91overdue_ratio'])*100),2,'.','');
	$arr[$i]['onday_ratio'] = number_format((($arr[$i]['onday_ratio'])*100),2,'.','');
	$arr[$i]['prepay_ratio'] = number_format((($arr[$i]['prepay_ratio'])*100),2,'.','');
	$arr[$i]['repay_num_proportion'] = number_format((($arr[$i]['repay_num_proportion'])*100),2,'.','');

}

echo  json_encode($arr);
