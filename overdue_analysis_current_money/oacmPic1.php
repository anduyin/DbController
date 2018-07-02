<?php
/* 金额-现状版柱形图展现文件
 * 金额部分
 * 一开始并没有
 * 需要自己选择条件显示
 *  
 *  */

require_once '../Common.php';
$query = "select status_time from overdue_analysis_current_money_tg group by status_time order by status_time desc";
$result = mysqli_query($link, $query);
$time = $result->fetch_all(MYSQLI_ASSOC);//查询当前最新时间
$statusTime = $time[0]['status_time'];
$query1 = "select field from overdue_analysis_current_money_tg group by field";
$result = mysqli_query($link, $query1);
$arr1 = $result->fetch_all(MYSQLI_ASSOC);//查询所有field字段
require_once 'oacmEdit.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>金额部分</title>
<script src="../jquery-3.2.1.min.js"></script>
<script src="../echarts.js"></script>
</head>
<body>
	<div>
	<p>请选择想要查看的条件</p>
	<a href="oacm.php">返回表格图</a>
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
	var arr1=[],arr2=[],arr3=[],arr4=[],arr5=[],arr6=[],arr7=[],arr8=[],arr9=[];
	for(var i in arr){
		arr1.push(arr[i]['field_value']);
		arr2.push(arr[i]['should_selfmoney']);
		arr3.push(arr[i]['overdue_selfmoney']);
		arr4.push(arr[i]['M1selfmoney']);
		arr5.push(arr[i]['M2selfmoney']);
		arr6.push(arr[i]['M3selfmoney']);
		arr7.push(arr[i]['Morethan_M4selfmoney']);
		arr8.push(arr[i]['borrow_selfmoney']);
		arr9.push(arr[i]['loaning_selfmoney']);
	}
	var brr = {};
	brr['arr1'] = arr1;
	brr['arr2'] = arr2;
	brr['arr3'] = arr3;
	brr['arr4'] = arr4;
	brr['arr5'] = arr5;
	brr['arr6'] = arr6;
	brr['arr7'] = arr7;
	brr['arr8'] = arr8;
	brr['arr9'] = arr9;
	return  brr;
	}
	var myChart = echarts.init(document.getElementById('main'));
	var json = <?php echo $jsonfirst?>;
	var b = getDom(json);
	myChart.setOption({
		title:{text:'金额-现状版金额柱形图'},
		grid:{left:50},
		tooltip:{trigger: 'axis'},
		legend: {
			data:["总应收本金","总应收未收本金","M1本金","M2本金","M3本金","坏账本金","放款本金","在贷本金"]
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
        	name:'金额(万元)'
        },			 	        
        series:[
        {
        	name:"总应收本金",
        	type:'bar',
        	data:b.arr2
        },
        {
        	name:"总应收未收本金",
        	type:'bar',
        	data:b.arr3
        },
        {
        	name:"M1本金",
        	type:'bar',
        	data:b.arr4
        },
        {
        	name:"M2本金",
        	type:'bar',
        	data:b.arr5
        },
        {
        	name:"M3本金",
        	type:'bar',
        	data:b.arr6
        },
        {
        	name:"坏账本金",
        	type:'bar',
        	data:b.arr7
        },
		{
        	name:"放款本金",
        	type:'bar',
        	data:b.arr8
        },
		{
        	name:"在贷本金",
        	type:'bar',
        	data:b.arr9
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
				url:"oacmEdit.php",
				data:data,
				type:"post",
				success:function(re){
					var a=getDom(re);
					myChart.setOption({
						title:{text:'金额-现状版金额柱形图'},
			 			grid:{left:50},
			 			tooltip:{trigger: 'axis'},
			 			legend: {
			 				data:["总应收本金","总应收未收本金","M1本金","M2本金","M3本金","坏账本金","放款本金","在贷本金"]
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
			 	        	name:'金额(万元)'
			 	        },			 	        
			 	        series:[
			 	        {
			 	        	name:"总应收本金",
			 	        	type:'bar',
			 	        	data:a.arr2
			 	        },
			 	        {
			 	        	name:"总应收未收本金",
			 	        	type:'bar',
			 	        	data:a.arr3
			 	        },
			 	        {
			 	        	name:"M1本金",
			 	        	type:'bar',
			 	        	data:a.arr4
			 	        },
			 	        {
			 	        	name:"M2本金",
			 	        	type:'bar',
			 	        	data:a.arr5
			 	        },
			 	        {
			 	        	name:"M3本金",
			 	        	type:'bar',
			 	        	data:a.arr6
			 	        },
			 	        {
			 	        	name:"坏账本金",
			 	        	type:'bar',
			 	        	data:a.arr7
			 	        },
						{
							name:"放款本金",
							type:'bar',
							data:a.arr8
						},
						{
							name:"在贷本金",
							type:'bar',
							data:a.arr9
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
