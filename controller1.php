<?php
session_start();
if($_SESSION['status']==0){
	echo "您没有权限查看";
	header("Location: Login.html");
}
$field = $_POST[1];
$date  = $_POST[0];
require_once 'Common.php';
$query = "select * from overdue_analysis_track where field = \"$field\" and status_time= \"$date\"";
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
	 if($arr[$i]['field_value']=="nan"){
                $arr[$i]['field_value']="不详";
        }

	$arr[$i]['T+0overdue_ratio'] = number_format((($arr[$i]['T+0overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+1overdue_ratio'] = number_format((($arr[$i]['T+1overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+2overdue_ratio'] = number_format((($arr[$i]['T+2overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+3overdue_ratio'] = number_format((($arr[$i]['T+3overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+4overdue_ratio'] = number_format((($arr[$i]['T+4overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+5overdue_ratio'] = number_format((($arr[$i]['T+5overdue_ratio'])*100),2,'.','');
	$arr[$i]['T+6overdue_ratio'] = number_format((($arr[$i]['T+6overdue_ratio'])*100),2,'.','');
	$arr[$i]['放款笔数占比'] = number_format((($arr[$i]['放款笔数占比'])*100),2,'.','');
}
if($field=="期数"){
	sort($arr);
}
echo  json_encode($arr); 
