<?php
/* 金额-现状版表格图展示文件 逾期分析
 * 默认第一次显示loan_name,field(总计,客户端来源)
 *  
 *  */
	
	require_once '../Common.php';
	$query = "select loan_name from overdue_analysis_current_plus_money_tg group by loan_name";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);//查询所有借款类型
	$query1 = "select field from overdue_analysis_current_plus_money_tg group by field";
	mysqli_query($link,'set names utf8');
	$result = mysqli_query($link, $query1);
	$arr1 = $result->fetch_all(MYSQLI_ASSOC);//查询所有field字段
	$sql = "select update_time from overdue_analysis_current_plus_money_tg group by update_time";
	mysqli_query($link,'set names utf8');
	$dateResult = mysqli_query($link, $sql);
	$dateInfo = $dateResult->fetch_all(MYSQLI_ASSOC);//查询所有更新时间
	rsort($dateInfo);
	$date = $dateInfo[0]['update_time'];
	$query2 = "select * from overdue_analysis_current_plus_money_tg where loan_name = \"总计\" and field= \"客户端来源\" and update_time =\"$date\"";
	$result = mysqli_query($link, $query2);
	$arr2 = $result->fetch_all(MYSQLI_ASSOC);//默认第一次打开的查询数据
	mysqli_close($link);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
			width:100;
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
	<title>逾期分析-金额-现状版</title>
	<script src="../jquery-3.2.1.min.js"></script>
	<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body style="background-color:#fff;">
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<div style="text-align: center" class="top">
		<!-- 时间和类别和借款类型选项  -->
		<form action="../download_analyze.php" method="post">
			<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">逾期分析></span>
            <span style="font-size:18px;color:#F44B2A;float:left;">金额-现状版</span>
			<!-- 类别选项 -->
			<select name="field" id="field">
				<?php foreach($arr1 as $f){?>
				<option value="<?php echo $f['field']?>"><?php echo $f['field']?></option>
				<?php }?>
			</select>
			<!-- 借款类型选项 -->
			<select name="loan_name" id="loan_name">
				<?php foreach($arr as $l){?>
				<option value="<?php echo $l['loan_name']?>"><?php echo $l['loan_name']?></option>
				<?php }?>
			</select>
			<!-- 时间选项 -->
			<select name="time" id="time">
				<?php foreach($dateInfo as $d){?>
				<option value="<?php echo $d['update_time']?>"><?php echo $d['update_time']?></option>
				<?php }?>
			</select>
			<input type="button" value="查询" id="button" class="btn">
			<input type='submit' value="下载" class="btn">
			<input type='hidden' name ="tmp" value='逾期分析-金额-现状版'>
			<a href="../overdue_analysis_current_plus_num_tg/oacpnt.php" class="href">笔数-现状版</a>
		</form>
	</div>
	<div id="t">
		<div class="title">
		</div>
		<table class="table table-hover table-bordered" border="1" style="color: #333;border-collapse:collapse;border-spacing: 0;text-align: center;margin:0;border:1px solid #e5e5e5;">
			<thead>
				<tr>
					<th width="100" class="active">借款类型</th>
					<th width="100" class="active">类别</th>
					<th width="100" class="active">具体类别</th>
					<th width="100" class="active">放款本金(万元)</th>
					<th width="100" class="active">在贷本金(万元)</th>
					<th width="100" class="active">总应收本金(万元)</th>
					<th width="100" class="active">总应收未收本金(万元)</th>
					<th width="100" class="active">总逾期率 (%)</th>
					<th width="100" class="active">M1本金(万元)</th>
					<th width="100" class="active">M1逾期率 (%)</th>
					<th width="100" class="active">M2本金(万元)</th>
					<th width="100" class="active">M2逾期率 (%)</th>
					<th width="100" class="active">M3本金(万元)</th>
					<th width="100" class="active">M3逾期率 (%)</th>
					<th width="100" class="active">坏账本金(万元)</th>
					<th width="100" class="active">坏账率 (%)</th>
					<th width="100" class="active">放款金额占比</th>
					<th width="100" class="active">数据更新时间</th>
				</tr>
			</thead>
			<tbody id="tbody">
				<!-- 第一次表的默认内容  -->
				<?php foreach($arr2 as $k => $v){?>
				<tr>
					<td width="100" class="active"><?php echo $v['loan_name'] ?></td>
					<td width="100" class="active"><?php echo $v['field'] ?></td>
					<td width="100" class="active"><?php echo $v['field_value'] ?></td>
					<td width="100" class="active"><?php echo number_format((($v['borrow_selfmoney'])/10000),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['loaning_selfmoney'])/10000),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['should_selfmoney'])/10000),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['overdue_selfmoney'])/10000),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['Totaloverdue_ratio'])*100),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['M1selfmoney'])/10000),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['M1overdue_ratio'])*100),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['M2selfmoney'])/10000),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['M2overdue_ratio'])*100),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['M3selfmoney'])/10000),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['M3overdue_ratio'])*100),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['Morethan_M4selfmoney'])/10000),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['Morethan_M4overdue_ratio'])*100),2,'.','')?></td>
					<td width="100" class="active"><?php echo number_format((($v['放款金额占比'])*100),2,'.','')?></td>
					<td width="100" class="active"><?php echo $v['update_time'] ?></td>
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
	function getWeek(loan_name,field,time){
		var data={};
		data[0] = loan_name;
		data[1] = field;
		data[2] = time;
		$.ajax({
			url:"oacpmtController.php",
			type:"post",
			data:data,
			success:function(re){				
				var arr = eval(re);
				var str = "";					
				for(var i in arr){
					var loan_name          = arr[i]['loan_name'];
					var field              = arr[i]['field'];
					var field_value        = arr[i]['field_value'];
					var borrow_selfmoney   = arr[i]['borrow_selfmoney'];
					var loaning_selfmoney  = arr[i]['loaning_selfmoney'];
					var should_selfmoney   = arr[i]['should_selfmoney'];
					var overdue_selfmoney  = arr[i]['overdue_selfmoney'];
					var Totaloverdue_ratio = arr[i]['Totaloverdue_ratio'];
					var M1selfmoney        = arr[i]['M1selfmoney'];
					var M1overdue_ratio    = arr[i]['M1overdue_ratio'];
					var M2selfmoney        = arr[i]['M2selfmoney'];
					var M2overdue_ratio    = arr[i]['M2overdue_ratio'];
					var M3selfmoney 	   = arr[i]['M3selfmoney'];
					var M3overdue_ratio    = arr[i]['M3overdue_ratio'];
					var Morethan_M4selfmoney   = arr[i]['Morethan_M4selfmoney'];
					var Morethan_M4overdue_ratio   = arr[i]['Morethan_M4overdue_ratio'];
					var Loan_amount_ratio = arr[i]['放款金额占比'];
					var update_time = arr[i]['update_time'];
					
					
					str +="<tr><td width='100' class='active'>"+loan_name+"</td>";
					str +="<td width='100' class='active'>"+field+"</td>";
					str +="<td width='100' class='active'>"+field_value+"</td>";
					str +="<td width='100' class='active'>"+borrow_selfmoney+"</td>";
					str +="<td width='100' class='active'>"+loaning_selfmoney+"</td>";
					str +="<td width='100' class='active'>"+should_selfmoney+"</td>";
					str +="<td width='100' class='active'>"+overdue_selfmoney+"</td>";
					str +="<td width='100' class='active'>"+Totaloverdue_ratio+"</td>";
					str +="<td width='100' class='active'>"+M1selfmoney+"</td>";
					str +="<td width='100' class='active'>"+M1overdue_ratio+"</td>";
					str +="<td width='100' class='active'>"+M2selfmoney+"</td>";
					str +="<td width='100' class='active'>"+M2overdue_ratio+"</td>";
					str +="<td width='100' class='active'>"+M3selfmoney+"</td>";
					str +="<td width='100' class='active'>"+M3overdue_ratio+"</td>";
					str +="<td width='100' class='active'>"+Morethan_M4selfmoney+"</td>";
					str +="<td width='100' class='active'>"+Morethan_M4overdue_ratio+"</td>";
					str +="<td width='100' class='active'>"+Loan_amount_ratio+"</td>";
					str +="<td width='100' class='active'>"+update_time+"</td></tr>";
				}			
				
				$("#tbody").empty();
				$("#tbody").append(str);
			}
		}) 
	}
	$("#button").click(function(){
		var loan_name = $("#loan_name").val();
		var field = $("#field").val();
		var time = $("#time").val();
		getWeek(loan_name,field,time);
	})
</script>
</html>
