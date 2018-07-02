<?php
/* 垫付数据表表格图处理数据文件(存管)
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */
require_once '../Common.php';

$date  = $_POST[0];
$query = "select * from data_details_should_be_mat_cg where status_time=\"$date\"";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
for($i=0;$i<count($arr);$i++){
	$arr[$i]['advance_payment']=number_format((($arr[$i]['advance_payment'])/10000),2,'.','');
	$arr[$i]['ture_advance_payment']=number_format((($arr[$i]['ture_advance_payment'])/10000),2,'.','');
	$arr[$i]['not_advance_payment']=number_format((($arr[$i]['not_advance_payment'])/10000),2,'.','');
}

echo  json_encode($arr); 
