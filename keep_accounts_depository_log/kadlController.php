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
		$query = "SELECT service,number,cost,date FROM `keep_accounts_depository_log` where date = \"$time1\"";
	}else{
		$query = "SELECT service,number,cost,date FROM `keep_accounts_depository_log` where date >= \"$time1\" and date <= \"$time2\"";
	}
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_NUM);
	mysqli_close($link);
	echo  json_encode($arr);
}
//计算接口服务费余额
function countMoney($link){
	$date = $_POST[0];
	$money = $_POST[1];
	$query = "SELECT cost FROM `keep_accounts_depository_log` where date >=\"$date\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	$the_residual_amount = 0;
	mysqli_close($link);
	foreach($arr as $v){
		$the_residual_amount += $v['cost'];
	}
	$answer = $money - $the_residual_amount;
	echo json_encode($answer);
}
//查询(总额)
function searchTotal($link){
	$time1 = $_POST[0];
	$time2  = $_POST[1];
	$time = '';
	if($time1==$time2){
		$time = $time2;
		$query = "SELECT number,cost FROM `keep_accounts_depository_log` where date = \"$time1\"";
	}else{
		$time = $time1."~".$time2;
		$query = "SELECT number,cost FROM `keep_accounts_depository_log` where date >= \"$time1\" and date <= \"$time2\"";
	}
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	$array = [];
	$total = [];
	$total[0] = '总计';
	foreach($arr as $v){
		@$total[1] += $v['number'];
		@$total[2] += $v['cost']; 
	}
	$total[3] = $time;
	$array[] = $total;
	echo  json_encode($array);
}
//查询(分类汇总)
function searchGroup($link){
	$time1 = $_POST[0];
	$time2  = $_POST[1];
	if($time1==$time2){
		$query = "SELECT service,number,cost,date FROM `keep_accounts_depository_log` where date = \"$time1\"";
	}else{
		$query = "SELECT service,number,cost,date FROM `keep_accounts_depository_log` where date >= \"$time1\" and date <= \"$time2\"";
	}
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	$number1 = 0;
	$cost1 = 0;
	$number2 = 0;
	$cost2 = 0;
	$number3 = 0;
	$cost3 = 0;
	$number4 = 0;
	$cost4 = 0;
	$number5 = 0;
	$cost5 = 0;
	
	foreach($arr as $v){
		switch($v['service']){
			case '鉴权';
			$number1 += $v['number'];
			$cost1 += $v['cost'];
			break;
			case '快捷支付';
			$number2 += $v['number'];
			$cost2 += $v['cost'];
			break;
			case '提现';
			$number3 += $v['number'];
			$cost3 += $v['cost'];
			break;
			case '其它充值';
			$number4 += $v['number'];
			$cost4 += $v['cost'];
			break;
			case '网银充值';
			$number5 += $v['number'];
			$cost5 += $v['cost'];
			break;
		}
	}
	$totalNumber = $number1+$number2+$number3+$number4+$number5;
	$totalCost = $cost1+$cost2+$cost3+$cost4+$cost5;
	$array = [];
	$arr1[0] = '鉴权';
	$arr1[1] = $number1;
	$arr1[2] = $cost1;
	$arr2[0] = '快捷支付';
	$arr2[1] = $number2;
	$arr2[2] = $cost2;
	$arr3[0] = '提现';
	$arr3[1] = $number3;
	$arr3[2] = $cost3;
	$arr4[0] = '其它充值';
	$arr4[1] = $number4;
	$arr4[2] = $cost4;
	$arr5[0] = '网银充值';
	$arr5[1] = $number5;
	$arr5[2] = $cost5;
	$arr6[0] = '总计';
	$arr6[1] = $totalNumber;
	$arr6[2] = $totalCost;
	$array[0] = $arr1;
	$array[1] = $arr2;
	$array[2] = $arr3;
	$array[3] = $arr4;
	$array[4] = $arr5;
	$array[5] = $arr6;
	echo  json_encode($array);
}
/**
 * 查询(按天汇总)
 * @param  [obj] $link [数据库对象]
 * @return [json]      [需要的数据]
 */
function searchDay($link){
	$time1 = $_POST[0];
	$time2  = $_POST[1];
	if($time1==$time2){		
		$query = "SELECT number,cost,date FROM `keep_accounts_depository_log` where date = \"$time1\"";
	}else{		
		$query = "SELECT number,cost,date FROM `keep_accounts_depository_log` where date >= \"$time1\" and date <= \"$time2\"";
	}
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	$total = count($arr);
	$array = array();
	$num = 0;
	for($i=0;$i<$total;$i+=5){
		$key = 0+$i;	
		$data = array_slice($arr,$key,5);
		$array[$num] = arrayMain($data);
		$num++;
	}
	echo json_encode($array);	
}

function arrayMain($data){
	$array = array();
	foreach($data as $v){
		$array[0] = '总计';
		@$array[1] += $v['number']; 
		@$array[2] += $v['cost'];
		$array[3] = $v['date'];
	}
	return $array;
}
/**
 * 获取某月第一天和最后一天
 * @param  [string] $date [日期]
 * @return [array]       [包含第一天和最后一天的日期]
 */
function getthemonth($date){
	$firstday = date('Y-m-01', strtotime($date));
	$lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
	return array($firstday,$lastday);
}
   
if($_POST&&$_POST[2]=='search'){
	searchDate($link);
}elseif($_POST&&$_POST[2]=='money'){
	countMoney($link);
}elseif($_POST&&$_POST[2]=='searchTotal'){
	searchTotal($link);
}elseif($_POST&&$_POST[2]=='searchGroup'){
	searchGroup($link);
}elseif($_POST&&$_POST[2]=='searchDay'){
	searchDay($link);
}
