<?php
/* 存管收费数据表展示文件
 *  */
	require_once '../Common.php';
	require_once 'feeRateCalculationController.php';
	$query = "SELECT * FROM `fee_rate_calculation` order by deal_id limit 0,30";//首次打开,显示30条
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	foreach($arr as $key=>$value){
	    $arr[$key]['is_36'] = $value['is_36'] == '0'?$value['is_36'] = '否':$value['is_36'] = '是';
    }
    //全部贷款类型
    $nameSql = "SELECT `name` FROM `fee_rate_calculation` GROUP BY `name`";
	$nameRe = mysqli_query($link, $nameSql);
	$name = $nameRe->fetch_all(MYSQLI_ASSOC);
	//全部放款状态
    $bidSql = "SELECT `bid_status` FROM `fee_rate_calculation` GROUP BY `bid_status`";
    $nameRe = mysqli_query($link, $bidSql);
    $bidStatus = $nameRe->fetch_all(MYSQLI_ASSOC);
    //全部是否36
    $is_36Sql = "SELECT `is_36` FROM `fee_rate_calculation` GROUP BY `is_36`";
    $is_36Re = mysqli_query($link, $is_36Sql);
    $is_36 = $is_36Re->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	$head = array('借款人','借款ID','手机号','贷款类型','放款状态','放款日','结清日','本金','管理费','利息','服务费','征信查询费','中介服务费','担保费','总加速服务费','借款人借款笔数','平均加速服务费','费率','是否超36','应退还金额');
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
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>费率测算</title>
	<script src="../jquery-3.2.1.min.js"></script>
	<script src="../handsontable-pro-master/dist/handsontable.full.min.js"></script>
	<link href="../handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">

</head>
<body style="background-color:#fff;">
	
	<div style="text-align: center" class="top">
		<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">图表 > </span>
        <span style="font-size:18px;color:#F44B2A;float:left;">费率测算</span>
    </div>
		<div class="search">
            <!--筛选条件：贷款类型，放款状态，放款日，结清日，是否超36,共5个，“是否超36”需显示为是否。-->
            <!-- 贷款类型 -->
            贷款类型:
            <select id = "name">
                <option value = "-1">全部</option>
                <?php foreach($name as $v){?>
                    <option value = "<?php echo $v['name']?>"><?php echo $v['name']?></option>
                <?php }?>
            </select>
            <!-- 贷款类型 End-->
            <!-- 放款状态 -->
            放款状态:
            <select id = "bid_status">
                <option value = "-1">全部</option>
                <?php foreach($bidStatus as $b){?>
                    <option value = "<?php echo $b['bid_status']?>"><?php echo $b['bid_status']?></option>
                <?php }?>
            </select>
            <!-- 放款状态 End-->
            <!--放款日-->
            放款日:
			<input type="date" value="" id = "loan_date1">
			&nbsp;&nbsp;至&nbsp;&nbsp;
			<input type="date" value="" id = "loan_date2">
            <!--放款日 End-->
            <!--结清日-->
            结清日:
            <input type="date" value="" id = "repay_date1">
            &nbsp;&nbsp;至&nbsp;&nbsp;
            <input type="date" value="" id = "repay_date2">
            <!--结清日 End-->
            <!-- 是否超36 -->
            是否超36:
            <select id = "is_36" style="width:50px">
                <option value = "-1">全部</option>
                <?php foreach($is_36 as $i){?>
                    <option value = "<?php echo $i['is_36']?>"><?php echo $i['is_36']=='0'?"否":"是"?></option>
                <?php }?>
            </select>
            <!-- 是否超36 End-->
			<input type="button" value="查询" id = "searchTotal" class="btn">
			<input type='button' value="下载" class="btn" id="download">
		</div>
	
	<div id="example" class="moneyTable"></div>
    <div id = page></div>
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
	var exportPlugin = hot.getPlugin('exportFile');
	$("#download").click(function(){
		hot.alter('insert_row', 0);
		var head = <?php echo $headjson?>;
		var headInfo = [];
			for(var h=0;h<head.length;h++){
				headInfo[h] = [0,h,head[h]];
			}
		hot.setDataAtCell(headInfo);
		exportPlugin.downloadFile('csv', {filename: '费率测算'});
	})

	//查询
	$("#searchTotal").click(function(){
		var info={};
		var name = $("#name").val();
		var bid_status = $("#bid_status").val();
		var loan_date1 = $("#loan_date1").val();
		var loan_date2 = $("#loan_date2").val();
		var repay_date1 = $("#repay_date1").val();
		var repay_date2 = $("#repay_date2").val();
		var is_36 = $("#is_36").val();
		info['name'] = name;
		info['bid_status'] = bid_status;
		info['loan_date1'] = loan_date1;
        info['loan_date2'] = loan_date2;
        info['repay_date1'] = repay_date1;
        info['repay_date2'] = repay_date2;
        info['is_36'] = is_36;
        info['code'] = 'searchTotal';
		$.ajax({
			url:"feeRateCalculationController.php",
			type:"post",
			data:info,
			success:function(re){
				hot.clear();
				var searchTotal = JSON.parse(re);
				hot.updateSettings({
   					data: searchTotal
				});
			}
		});
	})

	
</script>
</script>
</html>
