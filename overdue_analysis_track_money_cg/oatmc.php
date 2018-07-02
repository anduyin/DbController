<?php
/* 金额-回溯版表格图展示文件(存管)
 * 默认第一次显示贷款名称字段和最新时间的表格
 *  
 *  */
	
	require_once '../Common.php';
	$query = "select status_time from overdue_analysis_track_money_cg group by status_time order by status_time desc";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);//查询当前最新时间
	$statusTime = $arr[0]['status_time'];
	$query1 = "select field from overdue_analysis_track_money_cg group by field";
	mysqli_query($link,'set names utf8');
	$result = mysqli_query($link, $query1);
	$arr1 = $result->fetch_all(MYSQLI_ASSOC);//查询所有field字段
	$query2 = "select * from overdue_analysis_track_money_cg where status_time= \"$statusTime\" and field= \"贷款名称\"";
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
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>周表</title>
	<script src="../jquery-3.2.1.min.js"></script>
	<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body style="background-color:#fff;">
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<div style="text-align: center" class="top">
		<!-- 时间和字段选项  -->
		<form action="../download_cg.php" method="post">
			<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">风控数据(存管)></span>
            <span style="font-size:18px;color:#F44B2A;float:left;">金额-回溯版(存管)</span>
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
			<input type='hidden' name ="tmp" value='O.xlsx'>
			<a href="../overdue_analysis_track_num_cg/oatnc.php" class="href">笔数-回溯版(存管)</a>
			<a href="oatmcPic.php" class="href">柱形图</a>
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
					<th width="6%" style="font-size: 14px;">类别</th>
					<th width="6%" class="active">放款金额(万元)</th>
					<th width="6%" class="active">应还金额(万元)</th>
					<th width="6%" class="active">提前还款率(%)</th>
					<th width="6%" class="active">当天还款率(%)</th>
					<th width="6%" class="active">T+1逾期率  (%)</th>
					<th width="6%" class="active">T+2逾期率  (%)</th>
					<th width="6%" class="active">T+3逾期率  (%)</th>
					<th width="6%" class="active">T+4逾期率  (%)</th>
					<th width="6%" class="active">T+5逾期率  (%)</th>
					<th width="6%" class="active">T+6逾期率  (%)</th>
					<th width="6%" class="active">T+7逾期率  (%)</th>
					<th width="6%" class="active">T+31逾期率  (%)</th>
					<th width="6%" class="active">T+61逾期率  (%)</th>
					<th width="6%" class="active">T+91逾期率  (%)</th>
					<th width="6%" class="active">金额总占比(%)</th>
				
				</tr>
			</thead>
			<tbody id="tbody">
				<!-- 第一次表的默认内容  -->
				<?php foreach($arr2 as $k => $v){?>
				<tr>
					<td width="6%" style="font-size: 14px;"><?php echo $v['field_value']?></td>
					<td width="6%" class="active"><?php echo number_format((($v['repaymoney'])/10000),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['shouldmoney'])/10000),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['prepay_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['onday_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+1overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+2overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+3overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+4overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+5overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+6overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+7overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+31overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+61overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['T+91overdue_ratio'])*100),2,'.','')?></td>
					<td width="6%" class="active"><?php echo number_format((($v['repaymoney_proportion'])*100),2,'.','')?></td>
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
	function getWeek(date,field){
		var data={};
		data[0] = date;
		data[1] = field;
		$.ajax({
			url:"oatmcController.php",
			type:"post",
			data:data,
			success:function(re){
				//  console.log(re);return;
				var arr = eval(re);
				//  console.log(arr);
				var str = "";
				for(var i in arr){
					var field_value = arr[i]['field_value'];
					var repaymoney = arr[i]['repaymoney'];
					var shouldmoney = arr[i]['shouldmoney'];
					var prepay_ratio = arr[i]['prepay_ratio'];
					var onday_ratio = arr[i]['onday_ratio'];
					var T1overdue_ratio = arr[i]['T+1overdue_ratio'];
					var T2overdue_ratio = arr[i]['T+2overdue_ratio'];
					var T3overdue_ratio = arr[i]['T+3overdue_ratio'];
					var T4overdue_ratio = arr[i]['T+4overdue_ratio'];
					var T5overdue_ratio = arr[i]['T+5overdue_ratio'];
					var T6overdue_ratio = arr[i]['T+6overdue_ratio'];
					var T7overdue_ratio = arr[i]['T+7overdue_ratio'];
					var T31overdue_ratio = arr[i]['T+31overdue_ratio'];
					var T61overdue_ratio = arr[i]['T+61overdue_ratio'];
					var T91overdue_ratio = arr[i]['T+91overdue_ratio'];
					var repaymoney_proportion = arr[i]['repaymoney_proportion'];
					var field	=	arr[i]['field'];
					var status_time =arr[i]['status_time'];
					str +="<tr><td width='6%'>"+field_value+"</td><td width='6%' class='active'>"+repaymoney+"</td><td width='6%' class='active'>"+shouldmoney+"</td><td width='6%' class='active'>"+prepay_ratio+"</td><td width='6%' class='active'>"+onday_ratio+"</td><td width='6%' class='active'>"+T1overdue_ratio+"</td><td width='6%' class='active'>"+T2overdue_ratio+"</td><td width='6%' class='active'>"+T3overdue_ratio+"</td><td width='6%' class='active'>"+T4overdue_ratio+"</td><td width='6%' class='active'>"+T5overdue_ratio+"</td><td width='6%' class='active'>"+T6overdue_ratio+"</td><td width='6%' class='active'>"+T7overdue_ratio+"</td><td width='6%' class='active'>"+T31overdue_ratio+"</td><td width='6%' class='active'>"+T61overdue_ratio+"</td><td width='6%' class='active'>"+T91overdue_ratio+"</td><td width='6%' class='active'>"+repaymoney_proportion+"</td></tr>";
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
