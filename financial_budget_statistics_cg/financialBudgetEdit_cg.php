<?php
/* 收支预计柱形图数据处理文件(存管)
 * 处理Ajax数据
 * 返回json
 *  
 */ 
	$link = mysqli_connect('127.0.0.1','root','RFO9oYkjb^nNgXuE','xssdstat',3306);
	if(!$link){
		echo "失败";exit;
	}
	if(!$link){
		echo "失败";exit;
	}
	require_once '../Common.php';
	$now = date("Y-m-d",time()).' 00:00:00';
	$week = date('Y-m-d', strtotime('+6 days')).' 00:00:00';	
	if(isset($_POST[1])){
		$_POST[1]=$_POST[1];
	}else{
		$_POST[1]=$week;
	}
	$time2 =$_POST[1];
	if(isset($_POST[0])){    
		$_POST[0]=$_POST[0];
	}else{
		$_POST[0]=$now;
		$_POST['first']= 1;
	}
	$time1 = $_POST[0]; 
	if($time1==$time2){
		$query = "select * from financial_budget_statistics_cg where date = \"$time1\"";
	}else{
		$query = "select * from financial_budget_statistics_cg where date >= \"$time1\" and date <= \"$time2\"";
	}
	$result = mysqli_query($link, $query);
	$array = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
    	$arr = [];
    	foreach($array as $v){
    		$arr[] = $v;
    	}
    	
    	for($i=0;$i<count($arr);$i++){
			@$arr[$i]['date'] = date("Y-m-d",strtotime($arr[$i]['date']));
    		@$arr[$i]['manage_money'] = number_format((($arr[$i]['manage_money'])/10000),2,'.','');
			@$arr[$i]['true_manage_money'] = number_format((($arr[$i]['true_manage_money'])/10000),2,'.','');
			@$arr[$i]['advance_money'] = number_format((($arr[$i]['advance_money'])/10000),2,'.','');
			@$arr[$i]['true_advance_money'] = number_format((($arr[$i]['true_advance_money'])/10000),2,'.','');
			@$arr[$i]['not_advance_money'] = number_format((($arr[$i]['not_advance_money'])/10000),2,'.','');
			@$arr[$i]['recovered_advances_money'] = number_format((($arr[$i]['recovered_advances_money'])/10000),2,'.','');

		}
    	if(isset($_POST['first'])){
    		$jsonfirst = json_encode($arr);
    	}else{
    		echo json_encode($arr);
    	}   
?>