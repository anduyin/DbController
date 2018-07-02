<?php
/* 回溯表T+0折线图数据处理文件
 * 处理Ajax数据
 * 返回json
 *  
 *  */
session_start();
if($_SESSION['status']==0){
	echo "您没有权限查看";
	header("Location: Login.html");
}  
    $content = [];
    require_once '../Common.php';
    $sql = "select field_value from overdue_analysis_track where field = \"贷款名称\" group by field_value order by status_time";
    mysqli_query($link,"set names 'utf-8'");
    $result = mysqli_query($link, $sql);
    $farr = $result->fetch_all(MYSQLI_ASSOC);
    $num = count($farr);
    if(isset($_POST[1])){
    	$_POST[1]=$_POST[1];
    }else{
    	$_POST[1]=date("Y-m-d",time());
    }
    $date2  = $_POST[1];
    if(isset($_POST[0])){
    	$_POST[0]=$_POST[0];
    }else{
    	$_POST[0]=date("Y-m-d", strtotime("-2 month"));
    	$_POST['first']= 1;
    }
    $date1  = $_POST[0];
    for($i=0;$i<$num;$i++){
    $field_value = $farr[$i]['field_value'];
	$query = "select `T+0overdue_ratio`,field_value,status_time from overdue_analysis_track where status_time>= \"$date1\" and status_time<=\"$date2\" and field_value=\"$field_value\" group by status_time";	
	$result = mysqli_query($link, $query);
	$array = $result->fetch_all(MYSQLI_ASSOC);    	
    $arr = [];
    foreach($array as $v){
    		$arr[] = $v;
    	}
    for($a=0;$a<count($arr);$a++){
    $arr[$a]['T+0overdue_ratio']=number_format((($arr[$a]['T+0overdue_ratio'])*100),2,'.','');
	
    	}
    	$content[$i] = $arr;
    }

		if(isset($_POST['first'])){
    		$jsonfirst = json_encode($content);
    	}else{
    		echo json_encode($content);
    	} 
     
    

?>