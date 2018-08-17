<?php
/* 存管收费数据表展示文件
 *  */
	
	require_once '../Common.php';
	require_once 'kadlController.php';
	$today = date("Y-m-d");
    $day=getthemonth($today);
    $time1 = $day[0];
    $time2 = $day[1];
	$query = "SELECT number,cost,date FROM `keep_accounts_depository_log` where date >= \"$time1\" and date <= \"$time2\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	$total = count($arr);
	$array = array();
	$num = 0;
	for($i=0;$i<$total;$i+=5){
		$key = 0+$i;	
		$data = array_slice($arr,$key,5);
		$array[$num] = arrayMain($data);
		$num++;
	}
	$head = array('服务名称','服务调用次数','服务调用总费用','统计日期');
	$headjson = json_encode($head);
	$json = json_encode($array);
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
	<title>存管接口调用服务费</title>
	<script src="../jquery-3.2.1.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="../handsontable-pro-master/dist/handsontable.full.min.js"></script>
	<link href="../handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">

</head>
<body style="background-color:#fff;">
    <div style="text-align: center;width: 300px;"><img src="http://47.97.9.93:1050/pic/money.jpg" /></div>
	<div style="text-align: center" class="top">
		<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">财务(存管)></span>
        <span style="font-size:18px;color:#F44B2A;float:left;">存管接口调用服务费</span>
    </div>
		<div class='recharge'>
				<!-- 计算服务费功能 -->
			<span>计算接口服务费余额:</span>
			</br>
			<span>选择充值日期:</span>
			<input type="date" value="" id = "rechargeTime">
			</br>
			<span>充值金额(元):</span>
			<input type='input' value="" id="money">
			<input type='button' value="计算结果" class="btn" id="count">
			<span id = "answer"></span>
				<!-- 计算服务费功能 End-->
		</div>
		<div class="search">
			<input type="date" value="" id = "time1">
			&nbsp;&nbsp;至&nbsp;&nbsp;
			<input type="date" value="" id = "time2">
			<input type="button" value="查询(明细项)" id = "search" class="btn">
			<input type="button" value="查询(总额)" id = "searchTotal" class="btn">
			<input type="button" value="查询(分类汇总)" id = "searchGroup" class="btn">
			<input type="button" value="查询(按天汇总)" id = "searchDay" class="btn">
			<input type='button' value="下载" class="btn" id="download">
            <input type="button" id="pic" value="费用单价" class="btn">
		</div>
	
	<div id="example" class="moneyTable"></div>
	<div id='total'></div>
		
		
</body>
<script type="text/javascript">
var data = <?php echo $json;?>;
var container = document.getElementById('example');
var hot = new Handsontable(container, {
    data: data,
    rowHeaders: true,
    colHeaders: <?php echo $headjson?>,
    colWidths: 230,
    filters: true,
    dropdownMenu: true,
    manualColumnFreeze: true,
    forceNumeric: true,
    manualColumnResize: true,
    sortIndicator: true,
    columnSorting: true,
    fixedRowsBottom: 2
});
	
	function countTotal(){
		var num_total = 0;
		var cost_total = 0;
		var number = hot.getDataAtCol(1);
		var cost = hot.getDataAtCol(2);

		for(var i=0;i<cost.length;i++){
			num_total += parseInt(number[i]);
			cost_total += parseInt(cost[i]);
		}
		hot.alter('insert_row', null);
		var endRow = (hot.countRows())-1;
		var dataInfo = [];
			dataInfo = [[endRow, 0, '总计'],[endRow, 1, num_total],[endRow, 2, cost_total]];
			hot.setDataAtCell(dataInfo);
	}
	var exportPlugin = hot.getPlugin('exportFile');
	$("#download").click(function(){
		hot.alter('insert_row', 0);
		var head = <?php echo $headjson?>;
		var headInfo = [];
			for(var h=0;h<head.length;h++){
				headInfo[h] = [0,h,head[h]];
			}
		hot.setDataAtCell(headInfo);
		exportPlugin.downloadFile('csv', {filename: '存管接口调用服务费'});
	})
	//查询(明细项)
	$("#search").click(function(){
		var info={};
		var time1 = $("#time1").val();
		var time2 = $("#time2").val();
		info[0] = time1;
		info[1] = time2;
		info[2] = 'search';		
		if((time1=="")||(time2=="")){
				alert("时间范围选择错误");
				return;
			}
		$.ajax({
			url:"kadlController.php",
			type:"post",
			data:info,
			success:function(re){
				console.log(re);
				hot.clear();
				var search = JSON.parse(re);
				hot.updateSettings({
   					data: search
				});
			}
		});
	});
	//计算接口服务费余额
	$("#count").click(function(){
		var rechargeInfo = {};
		var money = $("#money").val();
		var rechargeTime = $("#rechargeTime").val();
		if(rechargeTime==""){
				alert("时间范围选择错误");
				return;
			}
		rechargeInfo[0] = rechargeTime;		
		rechargeInfo[1] = money;	
		rechargeInfo[2] = 'money';	
		$.ajax({
			url:"kadlController.php",
			type:"post",
			data:rechargeInfo,
			success:function(re){
				var num = re+'元';
				$("#answer").empty();
				$("#answer").html(num);
			}
		});
	});
	//查询(总额)
	$("#searchTotal").click(function(){
		var info={};
		var time1 = $("#time1").val();
		var time2 = $("#time2").val();
		info[0] = time1;
		info[1] = time2;
		info[2] = 'searchTotal';		
		if((time1=="")||(time2=="")){
				alert("时间范围选择错误");
				return;
			}
		$.ajax({
			url:"kadlController.php",
			type:"post",
			data:info,
			success:function(re){
				console.log(re);
				hot.clear();
				var searchTotal = JSON.parse(re);
				hot.updateSettings({
   					data: searchTotal
				});
			}
		});
	})
	//查询(分类汇总)
	$("#searchGroup").click(function(){
		var info={};
		var time1 = $("#time1").val();
		var time2 = $("#time2").val();
		info[0] = time1;
		info[1] = time2;
		info[2] = 'searchGroup';		
		if((time1=="")||(time2=="")){
				alert("时间范围选择错误");
				return;
			}
		$.ajax({
			url:"kadlController.php",
			type:"post",
			data:info,
			success:function(re){
				console.log(re);
				hot.clear();
				var searchGroup = JSON.parse(re);
				hot.updateSettings({
   					data: searchGroup
				});
			}
		});
	});
	//查询(按天汇总)
	$("#searchDay").click(function(){
		var info={};
		var time1 = $("#time1").val();
		var time2 = $("#time2").val();
		info[0] = time1;
		info[1] = time2;
		info[2] = 'searchDay';		
		if((time1=="")||(time2=="")){
				alert("时间范围选择错误");
				return;
			}
		$.ajax({
			url:"kadlController.php",
			type:"post",
			data:info,
			success:function(re){
				console.log(re);
				hot.clear();
				var searchDay = JSON.parse(re);
				hot.updateSettings({
   					data: searchDay
				});
			}
		});
	});
	var show = true;
	$("#pic").click(function () {
	    if(show == true){
            show = false;
            $('img').show();
        }else{
	        show = true;
	        $('img').hide();
        }

    })
</script>
</html>
