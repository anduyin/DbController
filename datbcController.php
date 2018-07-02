<?php
/* 利息金额表格图处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */
 session_start();
if($_SESSION['status']==0){
	echo "您没有权限查看";
	header("Location: Login.html");
} 

$date  = $_POST[0];
$link = mysqli_connect('127.0.0.1','root','RFO9oYkjb^nNgXuE','xssdstat',3306);
$query = "select * from data_amount_to_be_collected where status_time=\"$date\"";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
for($i=0;$i<count($arr);$i++){
	$arr[$i]['repay_money']=number_format((($arr[$i]['repay_money'])/10000),2,'.','');
	$arr[$i]['self_money']=number_format((($arr[$i]['self_money'])/10000),2,'.','');
	$arr[$i]['interest_money']=number_format((($arr[$i]['interest_money'])/10000),2,'.','');
	$arr[$i]['M0']=number_format((($arr[$i]['M0'])/10000),2,'.','');
	$arr[$i]['M1']=number_format((($arr[$i]['M1'])/10000),2,'.','');
	$arr[$i]['M2']=number_format((($arr[$i]['M2'])/10000),2,'.','');
	$arr[$i]['M3']=number_format((($arr[$i]['M3'])/10000),2,'.','');
	$arr[$i]['M4']=number_format((($arr[$i]['M4'])/10000),2,'.','');
	$arr[$i]['M5']=number_format((($arr[$i]['M5'])/10000),2,'.','');
	$arr[$i]['M6']=number_format((($arr[$i]['M6'])/10000),2,'.','');
	$arr[$i]['M7']=number_format((($arr[$i]['M7'])/10000),2,'.','');
	$arr[$i]['M8']=number_format((($arr[$i]['M8'])/10000),2,'.','');
	$arr[$i]['M9']=number_format((($arr[$i]['M9'])/10000),2,'.','');
	$arr[$i]['M10']=number_format((($arr[$i]['M10'])/10000),2,'.','');
	$arr[$i]['M11']=number_format((($arr[$i]['M11'])/10000),2,'.','');
	$arr[$i]['M12']=number_format((($arr[$i]['M12'])/10000),2,'.','');
}
//var_dump($arr);
echo  json_encode($arr); 
//echo $query;