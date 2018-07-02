<?php
/* 每日待收金额(存管)柱形图展现文件
 * 一开始并没有
 * 需要自己选择条件显示
 *  
 *  */

require_once '../Common.php';

require_once 'drmdlcEdit.php';
?>

<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>每日待收金额(存管)</title>
<script src="../jquery-3.2.1.min.js"></script>
<script src="../echarts.js"></script>
</head>
<body>
	<div>
	<p>请选择想要查看的条件</p>
	<a href="drmdlc.php">返回表格图</a>
	<form action="" method="post">
	<!-- 时间选项 -->
		<input type="date" value="" id = "time1">
		&nbsp;&nbsp;至&nbsp;&nbsp;
		<input type="date" value="" id = "time2">
		<input type="button" value="查询" id="button" class="btn btn-primary">
	</form>
	</div>
	<div style="width:1600px;height:800px" id="main">
	<script>
	function getDom(re){
	var arr = eval(re);
	var arr1=[],arr2=[],arr3=[],arr4=[],arr5=[],arr6=[],arr7=[];
	for(var i in arr){
		arr1.push(arr[i]['date']);
		arr2.push(arr[i]['deal_self_money']);
		arr3.push(arr[i]['deal_interest_money']);
		arr4.push(arr[i]['deal_manage_money']);
		arr5.push(arr[i]['deal_manage_impose_money']);
		arr6.push(arr[i]['loan_self_money']);
		arr7.push(arr[i]['loan_interest_money']);
				
	}
	var brr = {};
	brr['arr1'] = arr1;
	brr['arr2'] = arr2;
	brr['arr3'] = arr3;
	brr['arr4'] = arr4;
	brr['arr5'] = arr5;
	brr['arr6'] = arr6;
	brr['arr7'] = arr7;
	
	return  brr;
	}
	var myChart = echarts.init(document.getElementById('main'));
	var json = <?php echo $jsonfirst?>;
	console.log(json);
	var b = getDom(json);
	console.log(b.arr1);
	myChart.setOption({
		title:{text:'每日待收金额(存管)柱形图'},
		grid:{left:50},
		tooltip:{trigger: 'axis'},
		legend: {
			data:["待还本金","待还利息","待还管理费","待还逾期管理费","待收本金","待收利息"]
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
        	name:"待还本金",
        	type:'bar',
        	data:b.arr2
        },
        {
        	name:"待还利息",
        	type:'bar',
        	data:b.arr3
        },
        {
        	name:"待还管理费",
        	type:'bar',
        	data:b.arr4
        },
        {
        	name:"待还逾期管理费",
        	type:'bar',
        	data:b.arr5
        },
        {
        	name:"待收本金",
        	type:'bar',
        	data:b.arr6
        },
        {
        	name:"待收利息",
        	type:'bar',
        	data:b.arr7
        }				 	     
        ]
	});
		$("#button").click(function(){
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
				async : true, 
				url:"drmdlcEdit.php",
				data:data,
				type:"post",
				success:function(re){
					var a=getDom(re);
					myChart.setOption({
						title:{text:'每日待收金额(存管)'},
			 			grid:{left:50},
			 			tooltip:{trigger: 'axis'},
			 			legend: {
			 				data:["待还本金","待还利息","待还管理费","待还逾期管理费","待收本金","待收利息"]
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
			 	        	name:"待还本金",
			 	        	type:'bar',
			 	        	data:a.arr2
			 	        },
			 	        {
			 	        	name:"待还利息",
			 	        	type:'bar',
			 	        	data:a.arr3
			 	        },
			 	        {
			 	        	name:"待还管理费",
			 	        	type:'bar',
			 	        	data:a.arr4
			 	        },
			 	        {
			 	        	name:"待还逾期管理费",
			 	        	type:'bar',
			 	        	data:a.arr5
			 	        },
			 	        {
			 	        	name:"待收本金",
			 	        	type:'bar',
			 	        	data:a.arr6
			 	        },
			 	        {
			 	        	name:"待收利息",
			 	        	type:'bar',
			 	        	data:a.arr7
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
