<?php
/* 存管接口调用服务费处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
//查询(明细项)
function searchDate($link){
	$time1 = $_POST[0];
	$time2  = $_POST[1];
	if($time1==$time2){
		$query = "SELECT * FROM `self_manage_interest_money_tg` where date = \"$time1\"";
	}else{
		$query = "SELECT * FROM `self_manage_interest_money_tg` where date >= \"$time1\" and date <= \"$time2\"";
	}
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_NUM);
	mysqli_close($link);
	echo  json_encode($arr);
}

if($_POST&&$_POST[2]=='search'){
	searchDate($link);
}