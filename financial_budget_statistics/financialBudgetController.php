<?php
/* 收支预计表处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
$time = $_POST[0];
$query = "select * from financial_budget_statistics where update_date = \"$time\"";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
for($i=0;$i<count($arr);$i++){
	$arr[$i]['date'] = date("Y-m-d",strtotime($arr[$i]['date']));
	$arr[$i]['manage_money'] = number_format((($arr[$i]['manage_money'])/10000),2,'.','');
	if($arr[$i]['true_manage_money']===Null){
		$arr[$i]['true_manage_money'] =	'';
	}else{
		$arr[$i]['true_manage_money'] =	number_format((($arr[$i]['true_manage_money'])/10000),2,'.','');
	}
	$arr[$i]['advance_money'] = number_format((($arr[$i]['advance_money'])/10000),2,'.','');
	if($arr[$i]['true_advance_money']===Null){
		$arr[$i]['true_advance_money'] = '';
	}else{
		$arr[$i]['true_advance_money'] = number_format((($arr[$i]['true_advance_money'])/10000),2,'.','');
	}
	$arr[$i]['not_advance_money'] = number_format((($arr[$i]['not_advance_money'])/10000),2,'.','');
	if($arr[$i]['recovered_advances_money']===Null){
		$arr[$i]['recovered_advances_money'] = '';
	}else{
		$arr[$i]['recovered_advances_money'] = number_format((($arr[$i]['recovered_advances_money'])/10000),2,'.','');
	}
	$arr[$i]['update_date'] = date("Y-m-d",strtotime($arr[$i]['update_date']));
}
echo  json_encode($arr);