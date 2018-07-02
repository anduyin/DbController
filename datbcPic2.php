<?php
/* 逾期等级柱形图展现文件
 * 一开始并没有
 * 需要自己选择条件显示
 *  
 *  */
session_start();
if($_SESSION['status']==0){
	echo "您没有权限查看";
	header("Location: Login.html");
}

$link = mysqli_connect('127.0.0.1','root','RFO9oYkjb^nNgXuE','xssdstat',3306);
if(!$link){
	echo "失败";exit;
}
$query = "select status_time from data_amount_to_be_collected group by status_time order by status_time desc";
$result = mysqli_query($link, $query);
$time = $result->fetch_all(MYSQLI_ASSOC);
$timeFirst = $time[0]["status_time"];
require_once 'datbcEdit.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>周表</title>
<script src="jquery-3.2.1.min.js"></script>
<script src="echarts.js"></script>
</head>
<body>
	<div>
	<p>请选择想要查看的条件</p>
	<a href="datbc.php">返回表格图</a>
	<form action="" method="post">
	<!-- 时间选项 -->
	<input type="date" value="" id = "time1">
	&nbsp;&nbsp;至&nbsp;&nbsp;
	<input type="date" value="" id = "time2">
	数据统计日期:
	<select name="date" id="date">
				<?php foreach($time as $d){?>
				<option value="<?php echo $d['status_time']?>"><?php echo $d['status_time']?></option>
				<?php }?>
	</select>
	<input type="button" value="查询" id="button" class="btn btn-primary">
	<span id='tip'>时间范围请选择1个月,以免显示不全</span>
	</form>
	</div>
	<div style="width:1600px;height:800px" id="main">
	<script>
	function getDom(re){
	var arr = eval(re);
	var arr1=[],arr2=[],arr3=[],arr4=[],arr5=[],arr6=[],arr7=[],arr8=[],arr9=[],arr10=[],arr11=[],arr12=[],arr13=[],arr14=[];
	for(var i in arr){
		arr1.push(arr[i]['M0']);
		arr2.push(arr[i]['M1']);	
		arr3.push(arr[i]['M2']);
		arr4.push(arr[i]['M3']);
		arr5.push(arr[i]['M4']);
		arr6.push(arr[i]['M5']);
		arr7.push(arr[i]['M6']);
		arr8.push(arr[i]['M7']);
		arr9.push(arr[i]['M8']);
		arr10.push(arr[i]['M9']);
		arr11.push(arr[i]['M10']);
		arr12.push(arr[i]['M11']);
		arr13.push(arr[i]['M12']);
		arr14.push(arr[i]['repay_date']);
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
	brr['arr10'] = arr10;
	brr['arr11'] = arr11;
	brr['arr12'] = arr12;
	brr['arr13'] = arr13;
	brr['arr14'] = arr14;
	return  brr;
	}
	var myChart = echarts.init(document.getElementById('main'));
	var json = <?php echo $jsonfirst?>;
	var b = getDom(json);
	myChart.setOption({
		 title:{text:'逾期等级'
			},			
			tooltip:{trigger: 'axis'},
			legend: {
				data:["M0金额","M1金额","M2金额","M3金额","M4金额","M5金额","M6金额","M7金额","M8金额","M9金额","M10金额","M11金额","M12金额"]
	        },
	
	        xAxis:{
	        	type:"category",
	        	boundaryGap: true,
	        	axisLabel :{ 
			    	interval:0,
              rotate:30, 
			    	textStyle:{
		               fontSize:12
		            },
                margin:8   
                 },   
	        	data:b.arr14
	        	},
	        yAxis:{
	        	name:'金额(万元)',
				type:'value'
	        },
	        
	        series:[
	        
	        {
	        	name:"M0金额",
	        	type:'bar',
	        	data:b.arr1
	        },
	        
	        {
	        	name:"M1金额",
	        	type:'bar',
			
	        	data:b.arr2
	        },
	        
	        {
	        	name:"M2金额",
	        	type:'bar',
			
	        	data:b.arr3
	        },
	        
	 	       {
	        	name:"M3金额",
	        	type:'bar',
	        	data:b.arr4
	        },
	 	       {
	        	name:"M4金额",
	        	type:'bar',
	        	data:b.arr5
	        },
	 	       {
	        	name:"M5金额",
	        	type:'bar',
	        	data:b.arr6
	        },
	 	       {
	        	name:"M6金额",
	        	type:'bar',
	        	data:b.arr7
	        },
	 	       {
	        	name:"M7金额",
	        	type:'bar',
	        	data:b.arr8
	        },
	 	       {
	        	name:"M8金额",
	        	type:'bar',
	        	data:b.arr9
	        },
	 	       {
	        	name:"M9金额",
	        	type:'bar',
	        	data:b.arr10
	        },
	 	       {
	        	name:"M10金额",
	        	type:'bar',
	        	data:b.arr11
	        },
	 	       {
	        	name:"M11金额",
	        	type:'bar',
	        	data:b.arr12
	        },
	 	       {
	        	name:"M12金额",
	        	type:'bar',
	        	data:b.arr13
	        }
	 	       
	        
	        ]
	});
		$("#button").click(function(){
			var data={};
			var time1 = $("#time1").val();
			var time2 = $("#time2").val();
			var date  = $("#date").val();
			if((time1=="")||(time2=="")){
				alert("时间范围选择错误");
				return;
			}	
			data[0] = time1;
			data[1] = time2;
			data[2]	= date;			
			$.ajax({
				async : true, 
				url:"datbcEdit.php",
				data:data,
				type:"post",
				success:function(re){
					var a=getDom(re);
					
					myChart.setOption({
			        	 title:{text:'逾期等级'
			 			},
			 			
			 			tooltip:{trigger: 'axis'},
			 			legend: {
			 				data:["M0金额","M1金额","M2金额","M3金额","M4金额","M5金额","M6金额","M7金额","M8金额","M9金额","M10金额","M11金额","M12金额"]
			 	        },
				
			 	        xAxis:{
			 	        	type:"category",
			 	        	boundaryGap: true,
			 	        	axisLabel :{ 
						    	interval:0,
                                rotate:30, 
						    	textStyle:{
					               fontSize:12
					            },
                                  margin:8   
                                   },   
			 	        	data:a.arr14
			 	        	},
			 	        yAxis:{
			 	        	name:'金额(万元)',
							type:'value'
			 	        },
			 	        
			 	        series:[
			 	        
			 	        {
			 	        	name:"M0金额",
			 	        	type:'bar',
			 	        	data:a.arr1
			 	        },
			 	        
			 	        {
			 	        	name:"M1金额",
			 	        	type:'bar',
						
			 	        	data:a.arr2
			 	        },
			 	        
			 	        {
			 	        	name:"M2金额",
			 	        	type:'bar',
						
			 	        	data:a.arr3
			 	        },
			 	        
				 	       {
			 	        	name:"M3金额",
			 	        	type:'bar',
			 	        	data:a.arr4
			 	        },
				 	       {
			 	        	name:"M4金额",
			 	        	type:'bar',
			 	        	data:a.arr5
			 	        },
				 	       {
			 	        	name:"M5金额",
			 	        	type:'bar',
			 	        	data:a.arr6
			 	        },
				 	       {
			 	        	name:"M6金额",
			 	        	type:'bar',
			 	        	data:a.arr7
			 	        },
				 	       {
			 	        	name:"M7金额",
			 	        	type:'bar',
			 	        	data:a.arr8
			 	        },
				 	       {
			 	        	name:"M8金额",
			 	        	type:'bar',
			 	        	data:a.arr9
			 	        },
				 	       {
			 	        	name:"M9金额",
			 	        	type:'bar',
			 	        	data:a.arr10
			 	        },
				 	       {
			 	        	name:"M10金额",
			 	        	type:'bar',
			 	        	data:a.arr11
			 	        },
				 	       {
			 	        	name:"M11金额",
			 	        	type:'bar',
			 	        	data:a.arr12
			 	        },
				 	       {
			 	        	name:"M12金额",
			 	        	type:'bar',
			 	        	data:a.arr13
			 	        }
				 	       
			 	        
			 	        ]
			         });	
					
				}
			})
		})
		$(function(){
		$("#tip").hide();
 		$("#button").hover(function(){
  		$("#tip").show();
 		},function(){
  		$("#tip").hide();
 	});
});
	</script>
	</div>

</body>
</html>
