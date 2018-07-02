<?php
/* 垫付数据表所有的柱形图数据处理文件
 * 处理Ajax数据
 * 返回json
 *  
 *  */
session_start();
if($_SESSION['status']==0){
	echo "您没有权限查看";
	header("Location: Login.html");
}
    $link = mysqli_connect('127.0.0.1','root','RFO9oYkjb^nNgXuE','xssdstat',3306);
    if(isset($_POST[1])){
    	$_POST[1]=$_POST[1];
    }else{
    	$_POST[1]=date("Y-m-d",time());
    }
    $date2  = $_POST[1];
    if(isset($_POST[0])){
    	$_POST[0]=$_POST[0];
    }else{
    	$_POST[0]=date("Y-m-d", strtotime("-1 month"));
    	$_POST['first']= 1;
    }
    $date1  = $_POST[0];
    if(isset($_POST[2])){
    	$_POST[2]=$_POST[2];
    }else{
    	$_POST[2]=$timeFirst;
    }
    $date3 = $_POST[2];
    if($date1==$date2){
    	$query = "select * from data_details_should_be_mat where repay_date= \"$date1\" and status_time = \"$date3\"";
    }else{
    	$query = "select * from data_details_should_be_mat where repay_date >= \"$date1\" and repay_date <= \"$date2\" and status_time = \"$date3\"";
    
    }
	$result = mysqli_query($link, $query);
	$array = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
    	$arr = [];
    	foreach($array as $v){
    		$arr[] = $v;
    	}
    	for($i=0;$i<count($arr);$i++){
    $arr[$i]['advance_payment']=number_format((($arr[$i]['advance_payment'])/10000),2,'.','');
	$arr[$i]['ture_advance_payment']=number_format((($arr[$i]['ture_advance_payment'])/10000),2,'.','');
	$arr[$i]['not_advance_payment']=number_format((($arr[$i]['not_advance_payment'])/10000),2,'.','');
	$arr[$i]['difference_in_amount']=number_format((($arr[$i]['difference_in_amount'])/10000),2,'.','');
    	} 
    	
		if(isset($_POST['first'])){
    		$jsonfirst = json_encode($arr);
    	}else{
    		echo json_encode($arr);
    	}
    

?>