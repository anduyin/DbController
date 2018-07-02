<?php
/* 每日待收金额柱形图数据处理文件
 * 处理Ajax数据
 * 返回json
 *  
 */ 
	$link = mysqli_connect('127.0.0.1','root','RFO9oYkjb^nNgXuE','xssdstat',3306);
	if(!$link){
		echo "失败";exit;
	}
	
	require_once '../Common.php';
	$now = date("Y-m-d",time());
	$week = date('Y-m-d', strtotime('+6 days'));	
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
		$query = "select * from daily_repay_money_deal_loan where date = \"$time1\"";
	}else{
		$query = "select * from daily_repay_money_deal_loan where date >= \"$time1\" and date <= \"$time2\"";
	}
	$result = mysqli_query($link, $query);
	$array = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
    	$arr = [];
    	foreach($array as $v){
    		$arr[] = $v;
    	}
    	
    	for($i=0;$i<count($arr);$i++){
    		@$arr[$i]['deal_self_money'] = number_format((($arr[$i]['deal_self_money'])/10000),2,'.','');
			@$arr[$i]['deal_interest_money'] = number_format((($arr[$i]['deal_interest_money'])/10000),2,'.','');
			@$arr[$i]['deal_manage_money'] = number_format((($arr[$i]['deal_manage_money'])/10000),2,'.','');
			@$arr[$i]['deal_manage_impose_money'] = number_format((($arr[$i]['deal_manage_impose_money'])/10000),2,'.','');
			@$arr[$i]['loan_self_money'] = number_format((($arr[$i]['loan_self_money'])/10000),2,'.','');
			@$arr[$i]['loan_interest_money'] = number_format((($arr[$i]['loan_interest_money'])/10000),2,'.','');

		}
    	if(isset($_POST['first'])){
    		$jsonfirst = json_encode($arr);
    	}else{
    		echo json_encode($arr);
    	}   
?>