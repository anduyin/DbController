<?php
/* 金额-现状版柱形图数据处理文件
 * 处理Ajax数据
 * 返回json
 *  
 *  */
	
    require_once '../Common.php';
	$query = "select status_time from overdue_analysis_current_money_tg group by status_time order by status_time desc";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);//查询当前最新时间
	$statusTime = $arr[0]['status_time'];
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
	$query = "select * from overdue_analysis_current_money_tg where field = \"$field\" and status_time= \"$date\" group by field_value";
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
				unset($arr[$i]['should_selfmoney']);
				unset($arr[$i]['borrow_selfmoney']);
				unset($arr[$i]['loaning_selfmoney']);
				unset($arr[$i]['overdue_selfmoney']);
				unset($arr[$i]['Totaloverdue_ratio']);
			 	unset($arr[$i]['M1selfmoney']);
				unset($arr[$i]['M1overdue_ratio']);
				unset($arr[$i]['M2selfmoney']);
				unset($arr[$i]['M2overdue_ratio']);
				unset($arr[$i]['M3selfmoney']);
				unset($arr[$i]['M3overdue_ratio']);
				unset($arr[$i]['Morethan_M4selfmoney']);
				unset($arr[$i]['Morethan_M4overdue_ratio']);
					
			}elseif($arr[$i]['field_value']==''){
				$arr[$i]['field_value']='不祥';
			
			}
			@$arr[$i]['should_selfmoney'] = number_format((($arr[$i]['should_selfmoney'])/10000),2,'.','');
			@$arr[$i]['borrow_selfmoney'] = number_format((($arr[$i]['borrow_selfmoney'])/10000),2,'.','');
			@$arr[$i]['loaning_selfmoney'] = number_format((($arr[$i]['loaning_selfmoney'])/10000),2,'.','');
			@$arr[$i]['overdue_selfmoney'] = number_format((($arr[$i]['overdue_selfmoney'])/10000),2,'.','');
			@$arr[$i]['Totaloverdue_ratio'] = number_format((($arr[$i]['Totaloverdue_ratio'])*100),2,'.','');
			@$arr[$i]['M1selfmoney'] = number_format((($arr[$i]['M1selfmoney'])/10000),2,'.','');
			@$arr[$i]['M1overdue_ratio'] = number_format((($arr[$i]['M1overdue_ratio'])*100),2,'.','');
			@$arr[$i]['M2selfmoney'] = number_format((($arr[$i]['M2selfmoney'])/10000),2,'.','');
			@$arr[$i]['M2overdue_ratio'] = number_format((($arr[$i]['M2overdue_ratio'])*100),2,'.','');
			@$arr[$i]['M3selfmoney'] = number_format((($arr[$i]['M3selfmoney'])/10000),2,'.','');
			@$arr[$i]['M3overdue_ratio'] = number_format((($arr[$i]['M3overdue_ratio'])*100),2,'.','');
			@$arr[$i]['Morethan_M4selfmoney'] = number_format((($arr[$i]['Morethan_M4selfmoney'])/10000),2,'.','');
			@$arr[$i]['Morethan_M4overdue_ratio'] = number_format((($arr[$i]['Morethan_M4overdue_ratio'])*100),2,'.','');
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
