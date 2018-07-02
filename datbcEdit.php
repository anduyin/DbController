<?php
/* 利息金额表所有的柱形图数据处理文件
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
    	$query = "select * from data_amount_to_be_collected where repay_date= \"$date1\" and status_time = \"$date3\"";
    }else{
    	$query = "select * from data_amount_to_be_collected where repay_date >= \"$date1\" and repay_date <= \"$date2\" and status_time = \"$date3\"";
    
    }
	$result = mysqli_query($link, $query);
	$array = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
    	$arr = [];
    	foreach($array as $v){
    		$arr[] = $v;
    	}
    	for($i=0;$i<count($arr);$i++){
    $arr[$i]['self_money']=number_format((($arr[$i]['self_money'])/10000),2,'.','');
    $arr[$i]['interest_money']=number_format((($arr[$i]['interest_money'])/10000),2,'.','');
    $arr[$i]['repay_money']=number_format((($arr[$i]['repay_money'])/10000),2,'.','');
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
    	
    	if(isset($_POST['first'])){
    		$jsonfirst = json_encode($arr);
    	}else{
    		echo json_encode($arr);
    	}

?>