<?php
/* 收支预计表格图展示文件
 * 
 *  
 *  */
	
	require_once '../Common.php';
	//获取最大更新时间
    $sql = "select update_date from financial_budget_statistics  GROUP by update_date order by update_date DESC ";
    $re = mysqli_query($link,$sql);
    $arr = $re->fetch_all(MYSQLI_ASSOC);//更新时间数组
    $maxDate = $arr[0]['update_date'];
	$query2 = "select * from financial_budget_statistics where update_date =\"$maxDate\"";
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
	<title>收支预计</title>
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
            <span style="font-size:18px;color:#F44B2A;float:left;">收支预计</span>	
			<!-- 时间选项 -->
			<select name = 'time' id="time">
                <?php foreach($arr as $a){?>
                    <option value="<?php echo $a['update_date'];?>"><?php echo $a['update_date'];?></option>
                <?php }?>
            </select>
			<input type="button" value="查询" id="button" class="btn">
			<input type='submit' value="下载" class="btn">
			<input type='hidden' name ="tmp" value='C.xlsx'>
			<a href="financialBudgetPic.php" class="href">收支预计柱形图</a>
		</form>
	</div>
	<div id="t">
		<div class="title">
		
		
		</div>
		<table class="table table-hover table-bordered" border="1" style="color: #333;border-collapse:collapse;border-spacing: 0;text-align: center;margin:0;border:1px solid #e5e5e5;">
			<thead>
				<tr>
					<th width="6%" class = 'finacn'>ID</th>
					<th width="6%" class = 'finacn'>日期</th>
					<th width="6%" class = 'finacn'>应收借款管理费(万元)</th>
					<th width="6%" class = 'finacn'>实收借款管理费(万元)</th>
					<th width="6%" class = 'finacn'>应垫本息总额(万元)</th>
					<th width="6%" class = 'finacn'>实垫本息总额(万元)</th>
					<th width="6%" class = 'finacn'>无需垫付总额(万元)</th>
					<th width="6%" class = 'finacn'>已追回垫付金额(万元)</th>
					<th width="6%" class = 'finacn'>更新日期</th>				
				</tr>
			</thead>
			<tbody id="tbody">
				<!-- 第一次表的默认内容  -->
				<?php foreach($arr2 as $k => $v){?>
				<tr>
					<td width="6%" style="font-size: 14px;"><?php echo $v['id'];?></td>
					<td width="6%" class="active"><?php echo date("Y-m-d",strtotime($v['date']));?></td>
					<td width="6%" class="active"><?php echo number_format((($v['manage_money'])/10000),2,'.','')?></td>
					<td width="6%" class="active" <?php if(date("Y-m-d",strtotime($v['date']))>=$now&&date("Y-m-d",strtotime($v['date']))<=$end){?>style='background-color:#C6EFCE'<?php }?>>
						<?php if($v['true_manage_money']===Null){?>
							<?php echo '';?>
						<?php }else{?>
							<?php echo number_format((($v['true_manage_money'])/10000),2,'.','');?>
						<?php }?>
					</td>					
					<td width="6%" class="active"><?php echo number_format((($v['advance_money'])/10000),2,'.','')?></td>
					<td width="6%" class="active" <?php if(date("Y-m-d",strtotime($v['date']))>$now&&date("Y-m-d",strtotime($v['date']))<=$end){?>style='background-color:#C6EFCE'<?php }?>>
						<?php if($v['true_advance_money']===Null){?>
							<?php echo '';?>
						<?php }else{?>
							<?php echo number_format((($v['true_advance_money'])/10000),2,'.','');?>
						<?php }?>
					</td>					
					<td width="6%" class="active"><?php echo number_format((($v['not_advance_money'])/10000),2,'.','')?></td>
					<td width="6%" class="active" <?php if(date("Y-m-d",strtotime($v['date']))>=$now&&date("Y-m-d",strtotime($v['date']))<=$end){?>style='background-color:#C6EFCE'<?php }?>>
						<?php if($v['recovered_advances_money']===Null){?>
							<?php echo '';?>
						<?php }else{?>
							<?php echo number_format((($v['recovered_advances_money'])/10000),2,'.','');?>
						<?php }?>
					</td>
					<td width="6%" class="active"><?php echo date("Y-m-d",strtotime($v['update_date'])); ?></td>
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
		var time = $("#time").val();
		data[0] = time;
		$.ajax({
			url:"financialBudgetController.php",
			type:"post",
			data:data,
			success:function(re){
				//  console.log(re);return;
				var arr = eval(re);
				//  console.log(arr);
				var str = "";
				for(var i in arr){
					var id = arr[i]['id'];
					var date = arr[i]['date'];
					var manage_money = arr[i]['manage_money'];
					var true_manage_money = arr[i]['true_manage_money'];
					var advance_money = arr[i]['advance_money'];
					var true_advance_money = arr[i]['true_advance_money'];
					var not_advance_money = arr[i]['not_advance_money'];
					var recovered_advances_money = arr[i]['recovered_advances_money'];
					var update_date = arr[i]['update_date'];
					if(date>='<?php echo $now?>'&&date<='<?php echo $end?>'){						
						 tmm = "<td width='6%' class='active' style='background-color:#C6EFCE'>"+true_manage_money+"</td>";
						 ram = "<td width='6%' class='active' style='background-color:#C6EFCE'>"+recovered_advances_money+"</td>";
					}else{
						tmm = "<td width='6%' class='active'>"+true_manage_money+"</td>";						
						ram = "<td width='6%' class='active'>"+recovered_advances_money+"</td>";
					} 
					if(date>'<?php echo $now?>'&&date<='<?php echo $end?>'){
						tam = "<td width='6%' class='active' style='background-color:#C6EFCE'>"+true_advance_money+"</td>";
					}else{
						tam = "<td width='6%' class='active'>"+true_advance_money+"</td>";
					}
					str += "<tr><td width='6%' style='font-size: 14px;'>"+id+"</td>";
					str += "<td width='6%' class='active'>"+date+"</td>";
					str += "<td width='6%' class='active'>"+manage_money+"</td>";
					str += tmm;
					str += "<td width='6%' class='active'>"+advance_money+"</td>";
					str += tam;
					str += "<td width='6%' class='active'>"+not_advance_money+"</td>";
					str += ram;
					str += "<td width='6%' class='active'>"+update_date+"</td></tr>";					
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
