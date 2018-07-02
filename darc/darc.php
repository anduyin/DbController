<?php
/* 应收账款表格图(存管)展示文件
 * 默认第一次显示贷款名称字段和最新时间的表格
 *  
 *  */
require_once '../Common.php';
$query = "select status_time from data_accounts_receivable_cg group by status_time order by status_time desc";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
$num = count($arr) - 1;

$status_time1 = $arr[0]['status_time'];//当前最新时间
$status_time2 = $arr[$num]['status_time'];//最旧时间
$query1 = "select * from data_accounts_receivable_cg where status_time = \"$status_time1\"";
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
		font-size:16
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
<title>应收账款</title>
<script src="../jquery-3.2.1.min.js"></script>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<div style="text-align: center" class="top">
	<form action="../Finance_download_cg.php" method="post">
	<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">财务(存管)></span>
    <span style="font-size:18px;color:#F44B2A;float:left;">应收账款(存管)</span>
	<!-- 时间选项 -->
	<select name="date" id="date">
				<?php foreach($arr as $d){?>
				<option value="<?php echo $d['status_time']?>"><?php echo $d['status_time']?></option>
				<?php }?>
	</select>
	<input type='submit' value="下载" class="btn">
	<input type='hidden' name ="tmp" value='D.xlsx'>
	<input type="button" value="查询" id="button" class="btn btn-primary">
	<a href="darcPic1.php">应收账款数据图(存管)</a>
	</form>
	</div>
	<div id="t">
	<div class="title">
	<span id="sp">所有数据都是从<?php echo $status_time2?>至<?php echo $status_time1?></span>
	</div>
	<table  class="table table-hover table-bordered" style="text-align: center;margin:0;">
	<tr>
			<th width="11%" style="text-align: center">应还日期</th>
			<th width="11%" class="active">应还总额(万元)</th>
			<th width="11%" class="active">实还总额(万元)</th>
			<th width="11%" class="active">提前或准时还总额(万元)</th>
			<th width="11%" class="active">逾期已还总额(万元)</th>
			<th width="11%" class="active">隔天垫付总额(万元)</th>
			<th width="11%" class="active">30天垫付总额(万元)</th>
			<th width="11%" class="active">60天垫付总额(万元)</th>
			<th width="11%" class="active">90天垫付总额(万元)</th>
		</tr>
	</table>
	<div id='b' style="text-align:center;">
	<table  class="table table-hover table-bordered">
	<!-- 第一次表的默认内容  -->
	<?php foreach($arr1 as $k => $v){?>
		<tr>
			<td width="11%"><?php echo $v['repay_date']?></td>
			<td width="11%"  class="active"><?php echo number_format((($v['total_amount'])/10000),2,'.','')?></td>
			<td width="11%" class="active"><?php echo number_format((($v['ture_total_amount'])/10000),2,'.','')?></td>
			<td width="11%" class="active"><?php echo number_format((($v['Advance_money'])/10000),2,'.','')?></td>
			<td width="11%" class="active"><?php echo number_format((($v['overdue_ture_repay_money'])/10000),2,'.','')?></td>
			<td width="11%" class="active"><?php echo number_format((($v['advance_payment_1'])/10000),2,'.','')?></td>
			<td width="11%" class="active"><?php echo number_format((($v['advance_payment_30'])/10000),2,'.','')?></td>
			<td width="11%" class="active"><?php echo number_format((($v['advance_payment_60'])/10000),2,'.','')?></td>
			<td width="11%" class="active"><?php echo number_format((($v['advance_payment_90'])/10000),2,'.','')?></td>
			
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
		 url:"darcController.php",
		 type:"post",
		 data:data,
		 success:function(re){
			 //alert(re);return;
			 var arr = eval(re);
			 var str = "";
			 for(var i in arr){
				 var total_amount = arr[i]['total_amount'];
				 var ture_total_amount = arr[i]['ture_total_amount'];
				 var Advance_money = arr[i]['Advance_money'];
				 var overdue_ture_repay_money = arr[i]['overdue_ture_repay_money'];
				 var advance_payment_1 = arr[i]['advance_payment_1'];
				 var advance_payment_30 = arr[i]['advance_payment_30'];
				 var advance_payment_60 = arr[i]['advance_payment_60'];
				 var advance_payment_90 = arr[i]['advance_payment_90'];
				 var repay_date =arr[i]['repay_date'];
				 str +="<tr><td width='11%'>"+repay_date+"</td><td width='11%' class='active'>"+total_amount+"</td><td width='11%' class='active'>"+ture_total_amount+"</td><td width='11%' class='active'>"+Advance_money+"</td><td width='11%' class='active'>"+overdue_ture_repay_money+"</td><td width='11%' class='active'>"+advance_payment_1+"</td><td width='11%' class='active'>"+advance_payment_30+"</td><td width='11%' class='active'>"+advance_payment_60+"</td><td width='11%' class='active'>"+advance_payment_90+"</td></tr>";
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
