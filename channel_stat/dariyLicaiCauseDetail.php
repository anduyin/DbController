<?php

	require_once '../Common.php';
    require_once '../main.php';
	$main = new main();
	$field = $main->getColumnName($link,'dariy_licai_clause_detail');
	$head = $main->getColumnComment($link,'dariy_licai_clause_detail');
	//查询最新一天的实际回款日期
    $query_time = "SELECT true_repay_date FROM `dariy_licai_clause_detail` GROUP BY true_repay_date order by true_repay_date desc ";
    $result_time = mysqli_query($link,$query_time);
    $time = $result_time->fetch_all(MYSQLI_ASSOC);
    //默认展示最新一天数据
    $query = "SELECT {$field} FROM `dariy_licai_clause_detail` WHERE true_repay_date = '{$time[0]['true_repay_date']}' order by true_repay_date desc ";
    $result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	$headjson = json_encode($head);
	$json = json_encode($arr);
?>
<!DOCTYPE html>
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
			width: 1500px;
			height:50px;
			line-height:50px;
		}
		select{
			height:34px;
			width:100px;
			text-align:center;
		}
		.title{
			margin-bottom:10px;
			
		}
		.btn {
			
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
		#example {
			margin-left:300px; 
		}
		#money {
			width:70px;
		}
		.foot {
			text-align: center;
			width: 1500px;
			height:50px;
			line-height:50px;
		}
		
		.recharge {
			text-align: center;
			margin-bottom: 10px;
		}
		.search {
			text-align: center;
			margin-bottom: 10px;
		}
        img {
            display: none;
        }
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>每日回款用户明细</title>
	<script src="../jquery-3.2.1.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="../handsontable-pro-master/dist/handsontable.full.min.js"></script>
	<link href="../handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">

</head>
<body style="background-color:#fff;">
	<div style="text-align: center" class="top">
		<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">理财端日报 -> </span>
        <span style="font-size:18px;color:#F44B2A;float:left;">每日回款用户明细</span>
    </div>
		<div class="search">
			<input type="date" value="" id = "time1">
			&nbsp;&nbsp;至&nbsp;&nbsp;
			<input type="date" value="" id = "time2">
            <input type='button' value="查询" class="btn" id="search">
			<input type='button' value="下载" class="btn" id="download">
		</div>
	
	<div id="example" class="moneyTable"></div>

		
		
</body>
<script type="text/javascript">
var data = <?php echo $json;?>;
var container = document.getElementById('example');
var hot = new Handsontable(container, {
    data: data,
    rowHeaders: true,
    colHeaders: <?php echo $headjson?>,
    colWidths: [140,80,180,180,180,180,140,140,140,140,180,180,180,140],
    filters: true,
    dropdownMenu: false,
    manualColumnFreeze: true,
    forceNumeric: true,
    manualColumnResize: true,
    sortIndicator: true,
    columnSorting: true,
    readOnly:true,
    fixedRowsBottom: 2
});

	var exportPlugin = hot.getPlugin('exportFile');
	$("#download").click(function(){
		hot.alter('insert_row', 0);
		var head = <?php echo $headjson?>;
		var headInfo = [];
			for(var h=0;h<head.length;h++){
				headInfo[h] = [0,h,head[h]];
			}
		hot.setDataAtCell(headInfo);
		exportPlugin.downloadFile('csv', {filename: '每日回款用户明细'});
	})
	//查询
	$("#search").click(function(){
		var info={};
		var time1 = $("#time1").val();
		var time2 = $("#time2").val();
		info[0] = time1;
		info[1] = time2;
		info[2] = 'dariy_licai_clause_detail';
		if((time1=="")||(time2=="")){
				alert("时间范围选择错误");
				return;
			}
		$.ajax({
			url:"channel_stat_controller.php",
			type:"post",
			data:info,
			success:function(re){
				hot.clear();
				var search = JSON.parse(re);
				hot.updateSettings({
   					data: search
				});
			}
		});
	});
</script>
</html>
