<?php
/* 垫付数据表表格图处理数据文件
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
//$link = mysqli_connect('127.0.0.1','root','root','test',3306);
$link = mysqli_connect('127.0.0.1','root','RFO9oYkjb^nNgXuE','xssdstat',3306);
$query = "select * from data_details_should_be_mat where status_time=\"$date\"";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
for($i=0;$i<count($arr);$i++){
	$arr[$i]['advance_payment']=number_format((($arr[$i]['advance_payment'])/10000),2,'.','');
	$arr[$i]['ture_advance_payment']=number_format((($arr[$i]['ture_advance_payment'])/10000),2,'.','');
	$arr[$i]['not_advance_payment']=number_format((($arr[$i]['not_advance_payment'])/10000),2,'.','');
}
//var_dump($arr);
echo  json_encode($arr); 
//echo $query;