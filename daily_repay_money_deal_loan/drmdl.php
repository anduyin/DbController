<?php
/* 每日待收金额表格图展示文件
 * 
 *  
 *  */
	
	require_once '../Common.php';
	$query2 = "select * from daily_repay_money_deal_loan order by id desc";
	$result = mysqli_query($link, $query2);
	$arr2 = $result->fetch_all(MYSQLI_ASSOC);//默认第一次打开的查询数据
	mysqli_close($link);
		
?>

<html style="position: absolute; left: 0; top: 0;">
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
			padding: 8px;
			line-height: 1.42857143;
			vertical-align: top;
			background-color: #f5f5f5;
			font-size: 14px;
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
		.one{
			background-color:#87818F;
		}
		#t{
			padding:0 25px;
		}
		.title{
			margin-bottom:10px;
			
		}
		.btn {
			width: 54px;
			height: 34px;
			color: #fff;
			background-color: #337ab7;
			border: 1px solid #2e6da4;
			border-radius: 4px;
			display: inline-block;
			padding: 6px 12px;
			margin-bottom: 0;
			font-size: 14px;
			font-weight: 400;
			line-height: 1.42857143;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			cursor: pointer;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			background-image: none;
		}
		.href {
			color: #337ab7;
			text-decoration: none;
			font-size: 14px;
		}
		.finacn{
			text-align: center;
			padding: 8px;
			line-height: 1.42857143;
			vertical-align: top;
			font-size: 14px;
		}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>每日待收金额</title>
	<script src="../jquery-3.2.1.min.js"></script>
	<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body style="background-color:#fff;">
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<div style="text-align: center" class="top">
		<!-- 时间和字段选项  -->
		<form action="../download.php" method="post">
			<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">财务></span>
            <span style="font-size:18px;color:#F44B2A;float:left;">每日待收金额</span>	
			<!-- 时间选项 -->
			<input type="date" value="" id = "time1">
			&nbsp;&nbsp;至&nbsp;&nbsp;
			<input type="date" value="" id = "time2">
			<input type="button" value="查询" id="button" class="btn">
			<input type='submit' value="下载" class="btn">
			<input type='hidden' name ="tmp" value='D.xlsx'>
			<a href="drmdlPic.php" class="href">每日待收金额柱形图</a>
		</form>
	</div>
	<div id="t">
		<div class="title">
		
		
		</div>
		<table class="table table-hover table-bordered" border="1" style="color: #333;border-collapse:collapse;border-spacing: 0;text-align: center;margin:0;border:1px solid #e5e5e5;">
			<thead>
				<tr>
					<th width="6%" class = 'finacn'>ID</th>
					<th width="6%" class = 'finacn'>截止日期</th>
					<th width="6%" class = 'finacn'>待还本金(万元)</th>
					<th width="6%" class = 'finacn'>待还利息(万元)</th>
					<th width="6%" class = 'finacn'>待还管理费(万元)</th>
					<th width="6%" class = 'finacn'>待还逾期管理费(万元)</th>
					<th width="6%" class = 'finacn'>待收本金(万元)</th>
					<th width="6%" class = 'finacn'>待收利息(万元)</th>			
				</tr>
			</thead>
			<tbody id="tbody">
				<!-- 第一次表的默认内容  -->
				<?php foreach($arr2 as $k => $v){?>
				<tr>
					<td width="6%" style="font-size: 14px;"><?php echo $v['id'];?></td>
					<td width="6%" class="active"><?php echo $v['date'];?></td>
					<td width="6%" class="active"><?php echo number_format((($v['deal_self_money'])/10000),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['deal_interest_money'])/10000),2,'.','') ?></td>					
					<td width="6%" class="active"><?php echo number_format((($v['deal_manage_money'])/10000),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['deal_manage_impose_money'])/10000),2,'.','') ?></td>					
					<td width="6%" class="active"><?php echo number_format((($v['loan_self_money'])/10000),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['loan_interest_money'])/10000),2,'.','') ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div id='b' style="text-align:center;">
			<table  class="table table-hover table-bordered" border="1" style="width:100%;border-collapse:collapse;border-spacing: 0;text-align: center;margin:0;border:1px solid #e5e5e5;"></table>
		</div>
	</div>
	<div id="s"></div>
</body>
<script>
	function getWeek(){
		var data={};
		var time1 = $("#time1").val();
		var time2 = $("#time2").val();
		data[0] = time1;
		data[1] = time2;		
		if((time1=="")||(time2=="")){
				alert("时间范围选择错误");
				return;
			}
		$.ajax({
			url:"drmdlController.php",
			type:"post",
			data:data,
			success:function(re){
				
				var arr = eval(re);
				
				var str = "";
				for(var i in arr){
					var id = arr[i]['id'];
					var date = arr[i]['date'];
					var deal_self_money = arr[i]['deal_self_money'];
					var deal_interest_money = arr[i]['deal_interest_money'];
					var deal_manage_money = arr[i]['deal_manage_money'];
					var deal_manage_impose_money = arr[i]['deal_manage_impose_money'];
					var loan_self_money = arr[i]['loan_self_money'];
					var loan_interest_money = arr[i]['loan_interest_money'];
					str += "<tr><td width='6%' style='font-size: 14px;'>"+id+"</td>";
					str += "<td width='6%' class='active'>"+date+"</td>";
					str += "<td width='6%' class='active'>"+deal_self_money+"</td>";
					str += "<td width='6%' class='active'>"+deal_interest_money+"</td>";
					str += "<td width='6%' class='active'>"+deal_manage_money+"</td>";
					str += "<td width='6%' class='active'>"+deal_manage_impose_money+"</td>";
					str += "<td width='6%' class='active'>"+loan_self_money+"</td>";
					str += "<td width='6%' class='active'>"+loan_interest_money+"</td></tr>";					
				}			
		
				
				$("#tbody").empty();
				$("#tbody").append(str);
			}
		}) 
	}
	$("#button").click(function(){
		
		getWeek();
	})
</script>

</html>
