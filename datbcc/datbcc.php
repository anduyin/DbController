<?php
/* 利息金额表格图(存管)展示文件
 * 默认第一次显示贷款名称字段和最新时间的表格
 *  
 *  */
require_once '../Common.php';

$query = "select status_time from data_amount_to_be_collected_cg  group by status_time order by status_time desc";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
//var_dump($arr);exit;
$num = count($arr)-1;
$status_time1 = $arr[0]['status_time'];//当前最新时间
$status_time2 = $arr[$num]['status_time'];//最旧时间
$query1 = "select * from data_amount_to_be_collected_cg where status_time = \"$status_time1\"";
$result = mysqli_query($link, $query1);
$arr1 = $result->fetch_all(MYSQLI_ASSOC);//默认第一次打开的查询数据
mysqli_close($link);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
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
	}
	.one{
		background-color:#87818F;
	}
	#t{
		padding:0 25px;
	}
	.title{
		margin-bottom:10px;
		font-size:16px;
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
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>金额</title>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<div style="text-align: center" class="top">
	<!-- 时间选项  -->
	<form action="../Finance_download_cg.php" method="post">
	<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">财务(存管)></span>
        <span style="font-size:18px;color:#F44B2A;float:left;">利息金额(存管)</span>
	<!-- 时间选项 -->
	<select name="date" id="date">
				<?php foreach($arr as $d){?>
				<option value="<?php echo $d['status_time']?>"><?php echo $d['status_time']?></option>
				<?php }?>
	</select>
	<input type='submit' value="下载" class="btn btn-primary">
	<input type='hidden' name ="tmp" value='F.xlsx'>
	<input type="button" value="查询" id="button" class="btn btn-primary">
	<a href="datbccPic1.php">利息金额图(存管)</a>
	<a href="datbccPic2.php">逾期等级图(存管)</a>
	</form>
	</div>
	<div id="t">
	<div class="title">
	<span id="sp">所有数据都是从<?php echo $status_time2?>至<?php echo $status_time1?></span>
	</div>
	<table  class="table table-hover table-bordered" style="text-align: center;margin:0;">
	<tr>
			<th width="6%" style="text-align: center">待收日期</th>
			<th width="6%" class="active">待收本息(万元)</th>
			<th width="6%" class="active">待收本金(万元)</th>
			<th width="6%" class="active">待收利息(万元)</th>
			<th width="4%" class="active">待收笔数(笔)</th>
			<th width="6%" class="active">M0(万元)</th>
			<th width="6%" class="active">M1(万元)</th>
			<th width="6%" class="active">M2(万元)</th>
			<th width="6%" class="active">M3(万元)</th>
			<th width="6%" class="active">M4(万元)</th>
			<th width="6%" class="active">M5(万元)</th>
			<th width="6%" class="active">M6(万元)</th>
			<th width="5%" class="active">M7(万元)</th>
			<th width="5%" class="active">M8(万元)</th>
			<th width="5%" class="active">M9(万元)</th>
			<th width="5%" class="active">M10(万元)</th>
			<th width="5%" class="active">M11(万元)</th>
			<th width="5%" class="active">M12(万元)</th>
		</tr>
	</table>
	<div id='b' style="text-align:center;">
	<table  class="table table-hover table-bordered">
	<!-- 第一次表的默认内容  -->
	<?php foreach($arr1 as $k => $v){?>
		<tr>
			<td width="6%"><?php echo $v['repay_date']?></td>
			<td width="6%" class="active"><?php echo number_format((($v['repay_money'])/10000),2,'.','')?></td>
			<td width="6%" class="active"><?php echo number_format((($v['self_money'])/10000),2,'.','')?></td>
			<td width="6%" class="active"><?php echo number_format((($v['interest_money'])/10000),2,'.','')?></td>
			<td width="4%" class="active"><?php echo $v['count']?></td>
			<td width="6%" class="active"><?php echo number_format((($v['M0'])/10000),2,'.','')?></td>
			<td width="6%" class="active"><?php echo number_format((($v['M1'])/10000),2,'.','')?></td>
			<td width="6%" class="active"><?php echo number_format((($v['M2'])/10000),2,'.','')?></td>
			<td width="6%" class="active"><?php echo number_format((($v['M3'])/10000),2,'.','')?></td>
			<td width="6%" class="active"><?php echo number_format((($v['M4'])/10000),2,'.','')?></td>
			<td width="6%" class="active"><?php echo number_format((($v['M5'])/10000),2,'.','')?></td>
			<td width="6%" class="active"><?php echo number_format((($v['M6'])/10000),2,'.','')?></td>
			<td width="5%" class="active"><?php echo number_format((($v['M7'])/10000),2,'.','')?></td>
			<td width="5%" class="active"><?php echo number_format((($v['M8'])/10000),2,'.','')?></td>
			<td width="5%" class="active"><?php echo number_format((($v['M9'])/10000),2,'.','')?></td>
			<td width="5%" class="active"><?php echo number_format((($v['M10'])/10000),2,'.','')?></td>
			<td width="5%" class="active"><?php echo number_format((($v['M11'])/10000),2,'.','')?></td>
			<td width="5%" class="active"><?php echo number_format((($v['M12'])/10000),2,'.','')?></td>
		</tr>
	<?php } ?>
	</table>
	</div>
	</div>
	<div id="s">
	</div>
</body>
<script>
function getWeek(date){
	var data={};
	data[0] = date;
	 $.ajax({
		 url:"datbccController.php",
		 type:"post",
		 data:data,
		 success:function(re){
			 //alert(re);return;
			 var arr = eval(re);
			 var str = "";
			 for(var i in arr){
				 var repay_money = arr[i]['repay_money'];
				 var self_money = arr[i]['self_money'];
				 var interest_money = arr[i]['interest_money'];
				 var count = arr[i]['count'];
				 var M0 = arr[i]['M0'];
				 var M1 = arr[i]['M1'];
				 var M2 = arr[i]['M2'];
				 var M3 = arr[i]['M3'];
				 var M4 = arr[i]['M4'];
				 var M5 = arr[i]['M5'];
				 var M6 = arr[i]['M6'];
				 var M7 = arr[i]['M7'];
				 var M8 = arr[i]['M8'];
				 var M9 = arr[i]['M9'];
				 var M10 = arr[i]['M10'];
				 var M11 = arr[i]['M11'];
				 var M12 = arr[i]['M12'];
				 var repay_date =arr[i]['repay_date'];
				 str +="<tr><td width='6%'>"+repay_date+"</td><td width='6%' class='active'>"+repay_money+"</td><td width='6%' class='active'>"+self_money+"</td><td width='6%' class='active'>"+interest_money+"</td><td width='4%' class='active'>"+count+"</td><td width='6%' class='active'>"+M0+"</td><td width='6%' class='active'>"+M1+"</td><td width='6%' class='active'>"+M2+"</td><td width='6%' class='active'>"+M3+"</td><td width='6%' class='active'>"+M4+"</td><td width='6%' class='active'>"+M5+"</td><td width='6%' class='active'>"+M6+"</td><td width='5%' class='active'>"+M7+"</td><td width='5%' class='active'>"+M8+"</td><td width='5%' class='active'>"+M9+"</td><td width='5%' class='active'>"+M10+"</td><td width='5%' class='active'>"+M11+"</td><td width='5%' class='active'>"+M12+"</td></tr>";
			 }
			
			 var table = "<table class='table table-hover table-bordered'>"+str+"</table>";			 			 
			 $("#b").empty();			
			 $("#b").append(table);
		 }
	 }) 
}

 $("#button").click(function(){
	 var date = $("#date").val();	 
	 getWeek(date);
})

</script>
</html>
