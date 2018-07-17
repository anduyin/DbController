<?php
/* 收支预计表格图展示文件(存管)
 * 
 *  
 *  */
	
	require_once '../Common.php';
    $today = new DateTime();
    $endDay = $today->modify("+7 day")->format("Y-m-d");
    $today = new DateTime();
    $time = $today->modify("-3 day")->format("Y-m-d");
    $day = date('Y-m-d',time());
	$query2 = "select * from daily_collection_amount_statistics_tg where date>='$time' and date<='$endDay' and update_time = '$day'";
	$result = mysqli_query($link, $query2);
	$arr2 = $result->fetch_all(MYSQLI_ASSOC);//默认第一次打开的查询数据
	mysqli_close($link);
	$now = date("Y-m-d",time());
	$end = date("Y-m-d",time()+30*24*60*60);	
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
	<title>催收金额预计</title>
	<script src="../jquery-3.2.1.min.js"></script>
	<!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body style="background-color:#fff;">
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<div style="text-align: center" class="top">
		<!-- 时间和字段选项  -->
		<form action="../download.php" method="post">
			<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">催收项目></span>
            <span style="font-size:18px;color:#F44B2A;float:left;">催收金额预计(托管)</span>
			<!-- 时间选项 -->
			<input type="date" value="" id = "time1" name="time1">
			&nbsp;&nbsp;至&nbsp;&nbsp;
			<input type="date" value="" id = "time2" name="time2">
			<input type="button" value="查询" id="button" class="btn">
			<input type='submit' value="下载" class="btn">
			<input type='hidden' name ="tmp" value='F.xlsx'>
		</form>
	</div>
	<div id="t">
		<div class="title">
		
		
		</div>
		<table class="table table-hover table-bordered" border="1" style="color: #333;border-collapse:collapse;border-spacing: 0;text-align: center;margin:0;border:1px solid #e5e5e5;">
			<thead>
				<tr>
					<th width="6%" class = 'finacn'>日期</th>
					<th width="6%" class = 'finacn'>应收本息(万元)</th>
					<th width="6%" class = 'finacn'>应收借款管理费(万元)</th>
					<th width="6%" class = 'finacn'>实收本息(万元)</th>
					<th width="6%" class = 'finacn'>实收借款管理费(万元)</th>
					<th width="6%" class = 'finacn'>更新日期</th>				
				</tr>
			</thead>
			<tbody id="tbody">
				<!-- 第一次表的默认内容  -->
				<?php foreach($arr2 as $k => $v){?>
				<tr>
					<td width="6%" class="active"><?php echo $v['date'];?></td>
					<td width="6%" class="active"><?php echo number_format((($v['repay_money'])/10000),2,'.','')?></td>
                    <td width="6%" class="active"><?php echo number_format((($v['manage_money'])/10000),2,'.','')?></td>
					<td width="6%" class="active" <?php if($v['date']>=$now&&$v['date']<=$end){?>style='background-color:#C6EFCE'<?php }?>>
						<?php if($v['true_repay_money']===Null){?>
							<?php echo '';?>
						<?php }else{?>
							<?php echo number_format((($v['true_repay_money'])/10000),2,'.','');?>
						<?php }?>
					</td>
					<td width="6%" class="active" <?php if($v['date']>=$now&&$v['date']<=$end){?>style='background-color:#C6EFCE'<?php }?>>
						<?php if($v['true_manage_money']===Null){?>
							<?php echo '';?>
						<?php }else{?>
							<?php echo number_format((($v['true_manage_money'])/10000),2,'.','');?>
						<?php }?>
					</td>
					<td width="6%" class="active"><?php echo $v['update_time']; ?></td>
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
			url:"dcastController.php",
			type:"post",
			data:data,
			success:function(re){
				//  console.log(re);return;
				var arr = eval(re);
				//  console.log(arr);
				var str = "";
				for(var i in arr){
					var date = arr[i]['date'];
					var repay_money = arr[i]['repay_money'];
					var manage_money = arr[i]['manage_money'];
					var true_repay_money = arr[i]['true_repay_money'];
					var true_manage_money = arr[i]['true_manage_money'];
					var update_time = arr[i]['update_time'];
					if(date>='<?php echo $now?>'&&date<='<?php echo $end?>'){						
						 tmm = "<td width='6%' class='active' style='background-color:#C6EFCE'>"+true_repay_money+"</td>";
                         tam = "<td width='6%' class='active' style='background-color:#C6EFCE'>"+true_manage_money+"</td>";
					}else{
						tmm = "<td width='6%' class='active'>"+true_repay_money+"</td>";
                        tam = "<td width='6%' class='active'>"+true_manage_money+"</td>";
					}
					str += "<tr><td width='6%' class='active'>"+date+"</td>";
					str += "<td width='6%' class='active'>"+repay_money+"</td>";
					str += "<td width='6%' class='active'>"+manage_money+"</td>";
					str += tmm;
					str += tam;
					str += "<td width='6%' class='active'>"+update_time+"</td></tr>";
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
