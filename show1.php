<?php 
	session_start();
	 if($_SESSION['status']==0){
	 	echo "您没有权限查看";
	 	header("Location: Login.html");
	}
	require_once 'Common.php';
	$query = "select status_time from overdue_analysis_track group by status_time order by status_time desc";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);//查询当前最新时间
	$statusTime = $arr[0]['status_time'];
	$query1 = "select field from overdue_analysis_track group by field";
	mysqli_query($link,'set names utf8');
	$result = mysqli_query($link, $query1);
	$arr1 = $result->fetch_all(MYSQLI_ASSOC);//查询所有field字段
	$query2 = "select * from overdue_analysis_track where status_time= \"$statusTime\" and field= \"贷款名称\"";
	$result = mysqli_query($link, $query2);
	$arr2 = $result->fetch_all(MYSQLI_ASSOC);//默认第一次打开的查询数据
	mysqli_close($link);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
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
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>回溯表</title>
	<script src="jquery-3.2.1.min.js"></script>
	<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body style="background-color:#fff;">
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<div style="text-align: center" class="top">
		<!-- 时间和字段选项  -->
		<form action="download.php" method="post">
                        <span style="font-size:18px;color:#262626;float:left;margin-left:25px;">风控数据></span>
                        <span style="font-size:18px;color:#F44B2A;float:left;">回溯表</span>
			<!-- 字段选项 -->
			<select name="field" id="field">
				<?php foreach($arr1 as $f){?>
				<option value="<?php echo $f['field']?>"><?php echo $f['field']?></option>
				<?php }?>
			</select>
			<!-- 时间选项 -->
			<select name="date" id="date">
				<?php foreach($arr as $d){?>
				<option value="<?php echo $d['status_time']?>"><?php echo $d['status_time']?></option>
				<?php }?>
			</select>
			<input type="button" value="查询" id="button" class="btn">
			<input type='submit' value="下载" class="btn">
			<input type='hidden' name ="tmp" value='T.xlsx'>
			<a href="show.php" class="href">现状表</a>
			<a href="Tic.php" class="href">T逾期柱形图</a>
		</form>
	</div>
	<div id="t">
		<div class="title">
			<span id="sp">所有数据都是从7月1日至<?php echo $statusTime?></span>
			<span id="type">现在显示的数据类型是:贷款名称</span>
		</div>
		<table class="table table-hover table-bordered" border="1" style="color: #333;border-collapse:collapse;border-spacing: 0;text-align: center;margin:0;border:1px solid #e5e5e5;">
			<thead>
				<tr>
					<th width="10%" style="text-align: center;font-size:14px;">类别</th>
					<th width="10%" class="active">放款笔数&nbsp;(笔)</th>
					<th width="10%" class="active">T+0逾期率  &nbsp;(%)</th>
					<th width="10%" class="active">T+1逾期率  &nbsp;(%)</th>
					<th width="10%" class="active">T+2逾期率  &nbsp; (%)</th>
					<th width="10%" class="active">T+3逾期率  &nbsp;(%)</th>
					<th width="10%" class="active">T+4逾期率  &nbsp;(%)</th>
					<th width="10%" class="active">T+5逾期率  &nbsp;(%)</th>
					<th width="10%" class="active">T+6逾期率  &nbsp;(%)</th>
					<th width="10%" class="active">放款笔数占比 &nbsp;(%)</th>
				</tr>
			</thead>
			<tbody id="tbody">
				<!-- 第一次表的默认内容  -->
				<?php foreach($arr2 as $v){?>
				<tr>
					<td width="10%" style="text-align: center;font-size:14px;"><?php echo $v['field_value']?></td>
					<td width="10%" class="active"><?php echo $v['放款笔数']?></td>
					<td width="10%" class="active"><?php echo number_format((($v['T+0overdue_ratio'])*100),2,'.','') ?></td>
					<td width="10%" class="active"><?php echo number_format((($v['T+1overdue_ratio'])*100),2,'.','')?></td>
					<td width="10%" class="active"><?php echo number_format((($v['T+2overdue_ratio'])*100),2,'.','')?></td>
					<td width="10%" class="active"><?php echo number_format((($v['T+3overdue_ratio'])*100),2,'.','')?></td>
					<td width="10%" class="active"><?php echo number_format((($v['T+4overdue_ratio'])*100),2,'.','')?></td>
					<td width="10%" class="active"><?php echo number_format((($v['T+5overdue_ratio'])*100),2,'.','')?></td>
					<td width="10%" class="active"><?php echo number_format((($v['T+6overdue_ratio'])*100),2,'.','')?></td>
					<td width="10%" class="active"><?php echo number_format((($v['放款笔数占比'])*100),2,'.','')?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div id='b' style="text-align:center"><table  class="table table-hover table-bordered"></table></div>
	</div>
	<div id="s"></div>
</body>
	<script>
		function getWeek(date,field){
			var data={};
			data[0] = date;
			data[1] = field;
			$.ajax({
				url:"controller1.php",
				type:"post",
				data:data,
				success:function(re){
					//alert(re);return;
					var arr = eval(re);
					var str = "";
					for(var i in arr){
						var field_value = arr[i]['field_value'];
						var count = arr[i]['放款笔数'];
						var T0overdue_ratio = arr[i]['T+0overdue_ratio'];
						var T1overdue_ratio = arr[i]['T+1overdue_ratio'];
						var T2overdue_ratio = arr[i]['T+2overdue_ratio'];
						var T3overdue_ratio = arr[i]['T+3overdue_ratio'];
						var T4overdue_ratio = arr[i]['T+4overdue_ratio'];
						var T5overdue_ratio = arr[i]['T+5overdue_ratio'];
						var T6overdue_ratio = arr[i]['T+6overdue_ratio'];
						var count_proportion = arr[i]['放款笔数占比'];
						var field	=	arr[i]['field'];
						var status_time =arr[i]['status_time'];
						str +="<tr><td width='10%'>"+field_value+"</td><td width='10%' class='active'>"+count+"</td><td width='10%' class='active'>"+T0overdue_ratio+"</td><td width='10%' class='active'>"+T1overdue_ratio+"</td><td width='10%' class='active'>"+T2overdue_ratio+"</td><td width='10%' class='active'>"+T3overdue_ratio+"</td><td width='10%' class='active'>"+T4overdue_ratio+"</td><td width='10%' class='active'>"+T5overdue_ratio+"</td><td width='10%' class='active'>"+T6overdue_ratio+"</td><td width='10%' class='active'>"+count_proportion+"</td></tr>";
					}			
					
					var type  = "<span> 现在的数据显示类型是:"+field+"</span>";
					var date="<span style='font-size:16px'>统计周期从2017-07-01至"+status_time+"</span>";
					$("#tbody").empty();
					$("#sp").empty();
					$("#type").empty();
					$("#type").html(type);
					$("#sp").html(date);
					$("#tbody").append(str);
				}
			}) 
		}
		$("#button").click(function(){
			var date = $("#date").val();
			var field = $("#field").val();
			getWeek(date,field);
		})
	</script>
</html>
