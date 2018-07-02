<?php
/* 笔数-回溯版柱形图展现文件(存管)
 * 一开始并没有
 * 需要自己选择条件显示
 *  
 *  */

require_once '../Common.php';
$query = "select status_time from overdue_analysis_track_num_cg group by status_time order by status_time desc";
$result = mysqli_query($link, $query);
$time = $result->fetch_all(MYSQLI_ASSOC);//查询当前最新时间
$statusTime = $time[0]['status_time'];
$query1 = "select field from overdue_analysis_track_num_cg group by field";
$result = mysqli_query($link, $query1);
$arr1 = $result->fetch_all(MYSQLI_ASSOC);//查询所有field字段
mysqli_close($link);
require_once 'oatncEdit.php';
?>

<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>周表</title>
<script src="../jquery-3.2.1.min.js"></script>
<script src="../echarts.js"></script>
</head>
<body>
	<div>
	<p>请选择想要查看的条件</p>
	<a href="oatnc.php">返回表格图</a>
	<form action="" method="post">
	<!-- 字段选项 -->
	<select name="field" id="field">	
	<?php foreach($arr1 as $f){?>
		<option value="<?php echo $f['field']?>"><?php echo $f['field']?></option>
	<?php }?>
	</select>
	<!-- 时间选项 -->
	<select name="date" id="date">	
	<?php foreach($time as $d){?>
		<option value="<?php echo $d['status_time']?>"><?php echo $d['status_time']?></option>
	<?php }?>
	</select>
	<input type="button" value="查询" id="button" class="btn btn-primary">
	</form>
	</div>
	<div style="width:1600px;height:800px" id="main">
	<script>
	function getDom(re){
	var arr = eval(re);
	var arr1=[],arr3=[],arr4=[],arr5=[],arr6=[],arr7=[],arr8=[],arr9=[],arr10=[],arr11=[],arr12=[],arr13=[],arr14=[],arr15=[];
	for(var i in arr){
		arr1.push(arr[i]['field_value']);	
		arr3.push(arr[i]['T+1overdue_ratio']);
		arr4.push(arr[i]['T+2overdue_ratio']);
		arr5.push(arr[i]['T+3overdue_ratio']);
		arr6.push(arr[i]['T+4overdue_ratio']);
		arr7.push(arr[i]['T+5overdue_ratio']);
		arr8.push(arr[i]['T+6overdue_ratio']);
		arr9.push(arr[i]['T+7overdue_ratio']);
		arr10.push(arr[i]['count_proportion']);
		arr11.push(arr[i]['prepay_ratio']);
		arr12.push(arr[i]['onday_ratio']);
		arr13.push(arr[i]['T+31overdue_ratio']);
		arr14.push(arr[i]['T+61overdue_ratio']);
		arr15.push(arr[i]['T+91overdue_ratio']);
	}
	var brr = {};
	brr['arr1'] = arr1;
	brr['arr3'] = arr3;
	brr['arr4'] = arr4;
	brr['arr5'] = arr5;
	brr['arr6'] = arr6;
	brr['arr7'] = arr7;
	brr['arr8'] = arr8;
	brr['arr9'] = arr9;
	brr['arr10'] = arr10;
	brr['arr11'] = arr11;
	brr['arr12'] = arr12;
	brr['arr13'] = arr13;
	brr['arr14'] = arr14;
	brr['arr15'] = arr15;
	return  brr;
	}
	var myChart = echarts.init(document.getElementById('main'));
	var json = <?php echo $jsonfirst?>;
	var b = getDom(json);
	myChart.setOption({
		title:{text:'笔数-回溯版柱形图(存管)'},
		grid:{left:30},
		tooltip:{trigger: 'axis'},
		legend: {
			data:["提前还款率","当天还款率","T+1逾期率","T+2逾期率","T+3逾期率","T+4逾期率","T+5逾期率","T+6逾期率","T+7逾期率","T+31逾期率","T+61逾期率","T+91逾期率","总占比"]
			 	        }, 
        xAxis:{			 	        	
        	type:"category",
        	boundaryGap: true,
	axisLabel :{  
               interval:0,
               rotate:30,
               margin:8 
	},
        	data:b.arr1
        	},
        yAxis:{
        	name:'逾期率(%)'
        },			 	        
        series:[
        {
			 	        	name:"提前还款率",
			 	        	type:'bar',
			 	        	data:b.arr11
		},
		{
			 	        	name:"当天还款率",
			 	        	type:'bar',
			 	        	data:b.arr12
		},
        {
        	name:"T+1逾期率",
        	type:'bar',
        	data:b.arr3
        },
        {
        	name:"T+2逾期率",
        	type:'bar',
        	data:b.arr4
        },
        {
        	name:"T+3逾期率",
        	type:'bar',
        	data:b.arr5
        },
        {
        	name:"T+4逾期率",
        	type:'bar',
        	data:b.arr6
        },
        {
        	name:"T+5逾期率",
        	type:'bar',
        	data:b.arr7
        },
        {
        	name:"T+6逾期率",
        	type:'bar',
        	data:b.arr8
        },
        {
        	name:"T+7逾期率",
        	type:'bar',
        	data:b.arr9
        },
		{
			 	        	name:"T+31逾期率",
			 	        	type:'bar',
			 	        	data:b.arr13
			 	        },
						{
			 	        	name:"T+61逾期率",
			 	        	type:'bar',
			 	        	data:b.arr14
			 	        },
						{
			 	        	name:"T+91逾期率",
			 	        	type:'bar',
			 	        	data:b.arr15
			 	        },
	       {
        	name:"总占比",
        	type:'bar',
        	data:b.arr10
        }				 	     
        ]
	});
		$("#button").click(function(){
			var data={};
			var date = $("#date").val();
			var field = $("#field").val();
			data[0] = date;
			data[1] = field;
			data['field']= field;
			$.ajax({
				async : true, 
				url:"oatncEdit.php",
				data:data,
				type:"post",
				success:function(re){
					var a=getDom(re);
					myChart.setOption({
						title:{text:'笔数-回溯版柱形图(存管)'},
			 			grid:{left:30},
			 			tooltip:{trigger: 'axis'},
			 			legend: {
			 				data:["提前还款率","当天还款率","T+1逾期率","T+2逾期率","T+3逾期率","T+4逾期率","T+5逾期率","T+6逾期率","T+7逾期率","T+31逾期率","T+61逾期率","T+91逾期率","总占比"]
			 	        }, 
			 	        xAxis:{			 	        	
			 	        	type:"category",
			 	        	boundaryGap: true,
						axisLabel :{  
                                   interval:0,
                                   rotate:30,
                                   margin:8 
						},
			 	        	data:a.arr1
			 	        	},
			 	        yAxis:{
			 	        	name:'逾期率(%)'
			 	        },			 	        
			 	        series:[
			 	        {
			 	        	name:"提前还款率",
			 	        	type:'bar',
			 	        	data:a.arr11
			 	        },
						{
			 	        	name:"当天还款率",
			 	        	type:'bar',
			 	        	data:a.arr12
			 	        },
			 	        {
			 	        	name:"T+1逾期率",
			 	        	type:'bar',
			 	        	data:a.arr3
			 	        },
			 	        {
			 	        	name:"T+2逾期率",
			 	        	type:'bar',
			 	        	data:a.arr4
			 	        },
			 	        {
			 	        	name:"T+3逾期率",
			 	        	type:'bar',
			 	        	data:a.arr5
			 	        },
			 	        {
			 	        	name:"T+4逾期率",
			 	        	type:'bar',
			 	        	data:a.arr6
			 	        },
			 	        {
			 	        	name:"T+5逾期率",
			 	        	type:'bar',
			 	        	data:a.arr7
			 	        },
			 	        {
			 	        	name:"T+6逾期率",
			 	        	type:'bar',
			 	        	data:a.arr8
			 	        },
			 	        {
			 	        	name:"T+7逾期率",
			 	        	type:'bar',
			 	        	data:a.arr9
			 	        },
						{
			 	        	name:"T+31逾期率",
			 	        	type:'bar',
			 	        	data:a.arr13
			 	        },
						{
			 	        	name:"T+61逾期率",
			 	        	type:'bar',
			 	        	data:a.arr14
			 	        },
						{
			 	        	name:"T+91逾期率",
			 	        	type:'bar',
			 	        	data:a.arr15
			 	        },
				 	       {
			 	        	name:"总占比",
			 	        	type:'bar',
			 	        	data:a.arr10
			 	        }				 	     
			 	        ]
			         });	
					
				}
			})
		})
</script>
</div>
</body>
</html>
