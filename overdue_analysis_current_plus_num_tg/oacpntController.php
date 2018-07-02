<?php
/* 笔数-现状版表格图处理数据文件 逾期分析
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
$field = $_POST[1];
$loan_name  = $_POST[0];
$time = $_POST[2];
$query = "select * from overdue_analysis_current_plus_num_tg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
for($i=0;$i<count($arr);$i++){
	$arr[$i]['Totaloverdue_ratio'] = number_format((($arr[$i]['Totaloverdue_ratio'])*100),2,'.','');
	$arr[$i]['M1overdue_ratio'] = number_format((($arr[$i]['M1overdue_ratio'])*100),2,'.','');
	$arr[$i]['M2overdue_ratio'] = number_format((($arr[$i]['M2overdue_ratio'])*100),2,'.','');
	$arr[$i]['M3overdue_ratio'] = number_format((($arr[$i]['M3overdue_ratio'])*100),2,'.','');
	$arr[$i]['Morethan_M4overdue_ratio'] = number_format((($arr[$i]['Morethan_M4overdue_ratio'])*100),2,'.','');
	$arr[$i]['repay_num_proportion'] = number_format((($arr[$i]['repay_num_proportion'])*100),2,'.','');
}

echo  json_encode($arr);
