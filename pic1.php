<?php
/* 柱形图展现文件
 * 逾期率图
 * 一开始并没有
 * 需要自己选择条件显示
 *  
 *  */
session_start();
if($_SESSION['status']==0){
	echo "您没有权限查看";
	header("Location: Login.html");
}
require_once 'Common.php';
$query = "select status_time from overdue_analysis_current group by status_time order by status_time desc";
$result = mysqli_query($link, $query);
$time = $result->fetch_all(MYSQLI_ASSOC);//查询当前最新时间
$statusTime = $time[0]['status_time'];
$query1 = "select field from overdue_analysis_current group by field";
$result = mysqli_query($link, $query1);
$arr1 = $result->fetch_all(MYSQLI_ASSOC);//查询所有field字段
require_once 'edit.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>周表</title>
<script src="jquery-3.2.1.min.js"></script>
<script src="echarts.js"></script>
</head>
<body>
	<div>
	<a href="show.php">返回表格图</a>
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
	var arr1=[],arr2=[],arr3=[],arr4=[];
	for(var i in arr){
		arr1.push(arr[i]['field_value']);
		arr2.push(arr[i]['M1overdue_ratio']);
		arr3.push(arr[i]['M2overdue_ratio']);
		arr4.push(arr[i]['M3overdue_ratio']);
	}
	var brr = {};
	brr['arr1'] = arr1;
	brr['arr2'] = arr2;
	brr['arr3'] = arr3;
	brr['arr4'] = arr4;
	return  brr;
	}
	var myChart = echarts.init(document.getElementById('main'));
	var json = <?php echo $jsonfirst?>;
	var b = getDom(json);
	myChart.setOption({
		 title:{text:'周表'
			},
			tooltip:{trigger: 'axis'},
			grid:{left:30},
			legend: {
				data:["M1逾期率","M2逾期率","M3逾期率"]
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
	        	name:"M1逾期率",
	        	type:'bar',			 	        	
	        	data:b.arr2
	        },			 	        
	        {
	        	name:"M2逾期率",
	        	type:'bar',			 	        	
	        	data:b.arr3
	        },				 	       
	 	    {
	        	name:"M3逾期率",
	        	type:'bar',
	        	data:b.arr4
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
				url:"edit.php",
				data:data,
				type:"post",
				success:function(re){
					var a=getDom(re);
					myChart.setOption({
			        	 title:{text:'周表'
			 			},
			 			tooltip:{trigger: 'axis'},
			 			grid:{left:30},
			 			legend: {
			 				data:["M1逾期率","M2逾期率","M3逾期率"]
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
			 	        	name:"M1逾期率",
			 	        	type:'bar',			 	        	
			 	        	data:a.arr2
			 	        },			 	        
			 	        {
			 	        	name:"M2逾期率",
			 	        	type:'bar',			 	        	
			 	        	data:a.arr3
			 	        },				 	       
				 	    {
			 	        	name:"M3逾期率",
			 	        	type:'bar',
			 	        	data:a.arr4
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
