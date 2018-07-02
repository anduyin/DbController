<?php
/* 垫付数据表格图展示文件()
 * 默认第一次显示贷款名称字段和最新时间的表格
 *  
 *  */
require_once '../Common.php';

$query = "select status_time from data_details_should_be_mat_cg group by status_time order by status_time desc";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
//var_dump($arr);exit;
$num = count($arr) - 1;
$status_time1 = $arr[0]['status_time'];//当前最新时间
$status_time2 = $arr[$num]['status_time'];//最旧时间
$query1 = "select * from data_details_should_be_mat_cg where status_time = \"$status_time1\"";
$result = mysqli_query($link, $query1);
$arr1 = $result->fetch_all(MYSQLI_ASSOC);//默认第一次打开的查询数据
mysqli_close($link);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    body{
		background-color:#555555;
	}
	td{
		padding:5px 5px;
		text-align:center;
		
	}
	.active{
		text-align: right;
	}
	.one{
		background-color:#87818F;
	}
	#t{
		padding:0 25px;
	}
	.title{
		margin-bottom:10px;
		font-size:16px;
	}
	.top{
			height:50px;
			line-height:50px;
	}
	select{
			height:34px;
			width:100px;
			text-align:center;
	}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>垫付</title>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<div style="text-align: center" class="top">
	<form action=".//Finance_download_cg.php" method="post">
	<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">财务(存管)></span>
        <span style="font-size:18px;color:#F44B2A;float:left;">垫付数据(存管)</span>
	<!-- 时间选项 -->
	<select name="date" id="date">
				<?php foreach($arr as $d){?>
				<option value="<?php echo $d['status_time']?>"><?php echo $d['status_time']?></option>
				<?php }?>
	</select>
	<input type='submit' value="下载" class="btn btn-primary">
	<input type='hidden' name ="tmp" value='K.xlsx'>
	<input type="button" value="查询" id="button" class="btn btn-primary">
	<a href="ddsbmcPic1.php">垫付数据图</a>
	</form>
	</div>
	<div id="t">
	<div class="title">
	<span id="sp">所有数据都是从<?php echo $status_time2?>至<?php echo $status_time1?></span>
	</div>
	<table  class="table table-hover table-bordered" style="text-align: center;margin:0;">
	<tr>
			<th width="20%" style="text-align: center">应垫日期</th>
			<th width="20%" class="active">应垫付总额(万元)</th>
			<th width="20%" class="active">已垫付总额(万元)</th>
			<th width="20%" class="active">无需垫付总额(万元)</th>
			<th width="20%" class="active">差异金额(元)</th>
		</tr>
	</table>
	<div id='b' style="text-align:center;">
	<table  class="table table-hover table-bordered">
	<!-- 第一次表的默认内容  -->
	<?php foreach($arr1 as $k => $v){?>
		<tr>
			<td width="20%"><?php echo $v['repay_date']?></td>
			<td width="20%" class="active"><?php echo number_format((($v['advance_payment'])/10000),2,'.','')?></td>
			<td width="20%" class="active"><?php echo number_format((($v['ture_advance_payment'])/10000),2,'.','')?></td>
			<td width="20%" class="active"><?php echo number_format((($v['not_advance_payment'])/10000),2,'.','')?></td>
			<td width="20%" class="active"><?php echo $v['difference_in_amount']?></td>		
		</tr>
	<?php } ?>
	</table>
	</div>
	</div>
	<div id="s">
	</div>
</body>
<script>
function getWeek(date){
	var data={};
	data[0] = date;
	 $.ajax({
		 url:"ddsbmcController.php",
		 type:"post",
		 data:data,
		 success:function(re){
			 //alert(re);return;
			 var arr = eval(re);
			 var str = "";
			 for(var i in arr){
				 var advance_payment = arr[i]['advance_payment'];
				 var ture_advance_payment = arr[i]['ture_advance_payment'];
				 var not_advance_payment = arr[i]['not_advance_payment'];
				 var difference_in_amount = arr[i]['difference_in_amount'];
				 var repay_date =arr[i]['repay_date'];
				 str +="<tr><td width='20%'>"+repay_date+"</td><td width='20%' class='active'>"+advance_payment+"</td><td width='20%' class='active'>"+ture_advance_payment+"</td><td width='20%' class='active'>"+not_advance_payment+"</td><td width='20%' class='active'>"+difference_in_amount+"</td></tr>";
			 }
			
			 var table = "<table class='table table-hover table-bordered'>"+str+"</table>";
			 $("#b").empty();	
			 $("#b").append(table);
		 }
	 }) 
}

 $("#button").click(function(){
	 var date = $("#date").val();
	 getWeek(date);
})

</script>
</html>
