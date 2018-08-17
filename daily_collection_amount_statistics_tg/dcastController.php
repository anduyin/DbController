<?php
/* 收支预计表处理数据文件(存管)
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
$time1 = $_POST[0];
$time2  = $_POST[1];
if($time1==$time2){
	$query = "select * from daily_collection_amount_statistics_tg where date = \"$time1\"";
}else{
	$query = "select * from daily_collection_amount_statistics_tg where date >= \"$time1\" and date <= \"$time2\"";
}
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
for($i=0;$i<count($arr);$i++){
	$arr[$i]['repay_money'] = number_format((($arr[$i]['repay_money'])/10000),2,'.','');
	 
	if($arr[$i]['manage_money']===Null){
		$arr[$i]['manage_money'] =	'';
	}else{
		$arr[$i]['manage_money'] =	number_format((($arr[$i]['manage_money'])/10000),2,'.','');
	}
	$arr[$i]['true_repay_money'] = number_format((($arr[$i]['true_repay_money'])/10000),2,'.','');
	if($arr[$i]['true_manage_money']===Null){
		$arr[$i]['true_manage_money'] = '';
	}else{
		$arr[$i]['true_manage_money'] = number_format((($arr[$i]['true_manage_money'])/10000),2,'.','');
	}
    $arr[$i]['predict_repay_money'] = number_format((($arr[$i]['predict_repay_money'])/10000),2,'.','');
    $arr[$i]['predict_manage_money'] = number_format((($arr[$i]['predict_manage_money'])/10000),2,'.','');
}
echo  json_encode($arr);