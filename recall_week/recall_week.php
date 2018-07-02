<?php
/* 回溯表T+0表格图展示文件
 * 默认第一次显示贷款名称字段和最新时间的表格
 *  
 *  */
session_start();
if($_SESSION['status']==0){
	echo "您没有权限查看";
	header("Location: Login.html");
}
require_once '../Common.php';
$query1 = "select field_value  from overdue_analysis_track where field= \"贷款名称\" group by field_value ORDER BY status_time";
$result = mysqli_query($link, $query1);
$arr1 = $result->fetch_all(MYSQLI_ASSOC);//字段
$query2 = "select status_time  from overdue_analysis_track GROUP BY status_time";
$result = mysqli_query($link, $query2);
$arr2 = $result->fetch_all(MYSQLI_ASSOC);//时间
$num = count($arr2); 
for($i=0;$i<$num;$i++){
$str1 = "select `T+0overdue_ratio`,status_time,field_value  from overdue_analysis_track where status_time=";
$str2 = $arr2[$i]['status_time'];
$str3 = " and field = \"贷款名称\"";
$sql = $str1."'$str2'".$str3;
$result = mysqli_query($link, $sql);
$arr = $result->fetch_all(MYSQLI_ASSOC);
$brr[$i+1] = $arr;
}
mysqli_close($link);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	form{
		margin:5px 10px 0 10px;	
	}
	.t{
		text-align: center;
		margin:0;
		width:100%;
		padding:10px 0;
	}
	td{
		padding:10px 0;
		border: 1px solid #DDDDDD;
	}
	body{
		background-color:white;
	}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>周表</title>
</head>
<body>
	<div style="height: 40px;line-height:40px;">
	<span style="font-size:18px;color:#262626;float:left;margin-left:18px;">数据表></span>
        <span style="font-size:18px;color:#F44B2A;float:left;"> 每周T+0逾期率记录(回溯版)</span>
	</div>
	<form action="" method="post">		
	<input type='hidden' name ="tmp" value='F.xls'>
	<table class='t'>
			<tr>
				<td>统计日期</td>
				<?php foreach ($arr1 as $t) {?>
				<td><?php echo $t['field_value']?></td>
				<?php }?>
			</tr>
				<?php for($i=1;$i<=$num;$i++){?>
				<?php $v='$v'.$i;?>
			<tr>
				<td><?php echo $brr[$i][0]['status_time']?></td>
				<?php foreach($brr[$i] as $v){?>
				<td><?php echo number_format((($v['T+0overdue_ratio'])*100),3,'.','')."%"?></td>
				<?php }?>
			</tr>
			<?php }?>			
	</table>
	<input type='submit' value="下载">
	</form>
</body>
</html>
<?php
if(isset($_POST['tmp'])){
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="每周逾期率记录(回溯版).xlsx"');
header('Content-Transfer-Encoding: binary');
}
?>
