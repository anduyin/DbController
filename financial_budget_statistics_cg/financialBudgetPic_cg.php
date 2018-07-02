<?php
/* 收支预计柱形图展现文件(存管)
 * 一开始并没有
 * 需要自己选择条件显示
 *  
 *  */

require_once '../Common.php';

require_once 'financialBudgetEdit_cg.php';
?>

<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>收支预计(存管)</title>
<script src="../jquery-3.2.1.min.js"></script>
<script src="../echarts.js"></script>
</head>
<body>
	<div>
	<p>请选择想要查看的条件</p>
	<a href="financialBudget_cg.php">返回表格图</a>
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
		arr2.push(arr[i]['manage_money']);
		arr3.push(arr[i]['true_manage_money']);
		arr4.push(arr[i]['advance_money']);
		arr5.push(arr[i]['true_advance_money']);
		arr6.push(arr[i]['not_advance_money']);
		arr7.push(arr[i]['recovered_advances_money']);
				
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
	myChart.setOption({
		title:{text:'收支预计柱形图'},
		grid:{left:50},
		tooltip:{trigger: 'axis'},
		legend: {
			data:["应收借款管理费","实收借款管理费","应垫本息总额","实垫本息总额","无需垫付总额","已追回垫付金额"]
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
        	name:"应收借款管理费",
        	type:'bar',
        	data:b.arr2
        },
        {
        	name:"实收借款管理费",
        	type:'bar',
        	data:b.arr3
        },
        {
        	name:"应垫本息总额",
        	type:'bar',
        	data:b.arr4
        },
        {
        	name:"实垫本息总额",
        	type:'bar',
        	data:b.arr5
        },
        {
        	name:"无需垫付总额",
        	type:'bar',
        	data:b.arr6
        },
        {
        	name:"已追回垫付金额",
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
				url:"financialBudgetEdit_cg.php",
				data:data,
				type:"post",
				success:function(re){
					var a=getDom(re);
					myChart.setOption({
						title:{text:'收支预计柱形图(存管)'},
			 			grid:{left:50},
			 			tooltip:{trigger: 'axis'},
			 			legend: {
			 				data:["应收借款管理费","实收借款管理费","应垫本息总额","实垫本息总额","无需垫付总额","已追回垫付金额"]
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
			 	        	name:"应收借款管理费",
			 	        	type:'bar',
			 	        	data:a.arr2
			 	        },
			 	        {
			 	        	name:"实收借款管理费",
			 	        	type:'bar',
			 	        	data:a.arr3
			 	        },
			 	        {
			 	        	name:"应垫本息总额",
			 	        	type:'bar',
			 	        	data:a.arr4
			 	        },
			 	        {
			 	        	name:"实垫本息总额",
			 	        	type:'bar',
			 	        	data:a.arr5
			 	        },
			 	        {
			 	        	name:"无需垫付总额",
			 	        	type:'bar',
			 	        	data:a.arr6
			 	        },
			 	        {
			 	        	name:"已追回垫付金额",
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
