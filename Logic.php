<?php
/* 回溯表所有的柱形图数据处理文件
 * 处理Ajax数据
 * 返回json
 *  
 *  */
session_start();
if($_SESSION['status']==0){
	echo "您没有权限查看";
	header("Location: Login.html");
}	
    require_once 'Common.php';
    if(isset($_POST[1])){
    	$_POST[1]=$_POST[1];
    }else{
    	$_POST[1]="客户端来源";
    }
    $field =$_POST[1];
    if(isset($_POST[0])){
    	$_POST[0]=$_POST[0];
    }else{
    	$_POST[0]=$statusTime;
    	$_POST['first']= 1;
    }
    $date = $_POST[0];
	$query = "select * from overdue_analysis_track where field = \"$field\" and status_time= \"$date\" group by field_value";
	$result = mysqli_query($link, $query);
	$array = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
    	$arr = [];
    	foreach($array as $v){
    		$arr[] = $v;
    	}
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
			if($arr[$i]['field_value']=='总计'){
				$arr[$i]['field_value']='';
				unset( $arr[$i]['T+0overdue_ratio']);
				unset($arr[$i]['T+1overdue_ratio']);
				unset($arr[$i]['T+2overdue_ratio']);
			 	unset($arr[$i]['T+3overdue_ratio']);
				unset($arr[$i]['T+4overdue_ratio']);
				unset($arr[$i]['T+5overdue_ratio']);
				unset($arr[$i]['T+6overdue_ratio']);
				unset($arr[$i]['放款笔数占比']);
					
			}elseif($arr[$i]['field_value']=='nan'){
				$arr[$i]['field_value']='不祥';
			
			}
			@$arr[$i]['T+0overdue_ratio'] = number_format((($arr[$i]['T+0overdue_ratio'])*100),2,'.','');
			@$arr[$i]['T+1overdue_ratio'] = number_format((($arr[$i]['T+1overdue_ratio'])*100),2,'.','');
			@$arr[$i]['T+2overdue_ratio'] = number_format((($arr[$i]['T+2overdue_ratio'])*100),2,'.','');
			@$arr[$i]['T+3overdue_ratio'] = number_format((($arr[$i]['T+3overdue_ratio'])*100),2,'.','');
			@$arr[$i]['T+4overdue_ratio'] = number_format((($arr[$i]['T+4overdue_ratio'])*100),2,'.','');
			@$arr[$i]['T+5overdue_ratio'] = number_format((($arr[$i]['T+5overdue_ratio'])*100),2,'.','');
			@$arr[$i]['T+6overdue_ratio'] = number_format((($arr[$i]['T+6overdue_ratio'])*100),2,'.','');
			@$arr[$i]['放款笔数占比'] = number_format((($arr[$i]['放款笔数占比'])*100),2,'.','');
    	}
    	if($field=="期数"){
    		sort($arr);
    	}
		if(isset($_POST['first'])){
    		$jsonfirst = json_encode($arr);
    	}else{
    		echo json_encode($arr);
    	}        
?>
