<?php
/* 通过率表格图展示文件
 *  */
	
	require_once '../Common.php';
	$sql = "SELECT audit_date,first_audit_admin,type,pass_num,count,pass_ratio FROM `data_daily_pass_ratio` ";
	$firstData = mysqli_query($link, $sql);
	$firstOpen = $firstData->fetch_all(MYSQLI_NUM);//第一次打开内容
	foreach($firstOpen as $k=>$v){
		$firstOpen[$k][5] = number_format(($v[5]*100),2,'.','').'%';
	}
	mysqli_close($link);
	$head = array('审核时间','审单员','贷款类型','通过数','审核数','通过率');
	$headjson = json_encode($head);
	$json = json_encode($firstOpen);
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
			padding:0 0 150px 100px;

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
			margin-left:200px; 
		}
		
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>通过率</title>
	<script src="../jquery-3.2.1.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="../handsontable-pro-master/dist/handsontable.full.min.js"></script>
	<link href="../handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">

</head>
<body style="background-color:#fff;">
	
	<div style="text-align: center" class="top">
		<form action="" method="post">
			<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">风控数据></span>
            <span style="font-size:18px;color:#F44B2A;float:left;">通过率</span>
			<div>
				<input type="button" value="查询总数" id="button" class="btn">
				<input type='button' value="下载" class="btn" id="download">
			</div>
		</form>
	</div>
	<div id="example"></div>
	<div id='total'></div>	
		
</body>
<script type="text/javascript">
	var data = <?php echo $json;?>

var container = document.getElementById('example');
var hot = new Handsontable(container, {
  data: data,
  rowHeaders: true,
  colHeaders: <?php echo $headjson?>,
  colWidths: 200,
  filters: true,
  dropdownMenu: true,
  manualColumnFreeze: true,
  forceNumeric: true,
  manualColumnResize: true,
  sortIndicator: true,
  columnSorting: true,
});
	
	$("#button").click(function(){
		var pass_num_total = 0;
		var count_total = 0;
		var pass_ratio_total = 0;
		var pass_num = hot.getDataAtCol(3);
		var count = hot.getDataAtCol(4);
		for(var i=0;i<count.length;i++){
			pass_num_total += parseInt(pass_num[i]);
			count_total += parseInt(count[i]);
		}
		pass_ratio_total = (pass_num_total/count_total)*100;
		pass_ratio_total = (pass_ratio_total.toFixed(2))+'%';
		hot.alter('insert_row', null);
		var endRow = (hot.countRows())-1;
		var dataInfo = [];
			dataInfo = [[endRow, 2, '总计'],[endRow, 3, pass_num_total],[endRow, 4, count_total],[endRow, 5, pass_ratio_total]];
			hot.setDataAtCell(dataInfo);
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
		exportPlugin.downloadFile('csv', {filename: '通过率'});
	})
</script>
</script>
</html>
