<?php
/* 应收账款柱形图展现文件
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
$link = mysqli_connect('127.0.0.1','root','RFO9oYkjb^nNgXuE','xssdstat',3306);
if(!$link){
	echo "失败";exit;
}
$query = "select status_time from data_accounts_receivable group by status_time order by status_time desc";
$result = mysqli_query($link, $query);
$time = $result->fetch_all(MYSQLI_ASSOC);
$timeFirst = $time[0]["status_time"];
require_once 'darEdit.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>逾期率图</title>
<script src="jquery-3.2.1.min.js"></script>
<script src="echarts.js"></script>
</head>
<body>
	<div>
	<a href="dar.php">返回表格图</a>
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
	var arr1=[],arr2=[],arr3=[],arr4=[],arr5=[],arr6=[],arr7=[],arr8=[],arr9=[];
	for(var i in arr){
		arr1.push(arr[i]['total_amount']);
		arr2.push(arr[i]['ture_total_amount']);
		arr3.push(arr[i]['Advance_money']);
		arr4.push(arr[i]['overdue_ture_repay_money']);
		arr5.push(arr[i]['advance_payment_1']);
		arr6.push(arr[i]['advance_payment_30']);
		arr7.push(arr[i]['advance_payment_60']);
		arr8.push(arr[i]['advance_payment_90']);
		arr9.push(arr[i]['repay_date']);
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
		 title:{text:'周表'
			},
			tooltip:{trigger: 'axis'},
			
			legend: {
				data:["应还总额","实还总额","提前或准时还总额","逾期已还总额","隔天应垫总额","30天应垫总额","60天应垫总额","90天应垫总额"]
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
	        	data:b.arr9
	        	},
	        yAxis:{
	        	name:'金额(万元)'
	        },
	        
	        series:[
	        
	        {
	        	name:"应还总额",
	        	type:'bar',			 	   
	        	data:b.arr1
	        },
	        
	        {
	        	name:"实还总额",
	        	type:'bar',
	        	
	        	data:b.arr2
	        },
	 	       
	 	       {
	        	name:"提前或准时还总额",
	        	type:'bar',
	        	
	        	data:b.arr3
	        },
	 	       {
	        	name:"逾期已还总额",
	        	type:'bar',
	        	
	        	data:b.arr4
	        },
	 	       {
	        	name:"隔天应垫总额",
	        	type:'bar',
	        	
	        	data:b.arr5
	        },
	 	       {
	        	name:"30天应垫总额",
	        	type:'bar',
	        	
	        	data:b.arr6
	        },
	 	       {
	        	name:"60天应垫总额",
	        	type:'bar',
	        	
	        	data:b.arr7
	        },
	 	       {
	        	name:"90天应垫总额",
	        	type:'bar',
	        	
	        	data:b.arr8
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
			data[2] = date;
			$.ajax({
				async : true, 
				url:"darEdit.php",
				data:data,
				type:"post",
				success:function(re){
					var a=getDom(re);
					myChart.setOption({
			        	 title:{text:'周表'
			 			},
			 			tooltip:{trigger: 'axis'},
			 			
			 			legend: {
			 				data:["应还总额","实还总额","提前或准时还总额","逾期已还总额","隔天应垫总额","30天应垫总额","60天应垫总额","90天应垫总额"]
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
			 	        	data:a.arr9
			 	        	},
			 	        yAxis:{
			 	        	name:'金额(万元)'
			 	        },
			 	        
			 	        series:[
			 	        
			 	        {
			 	        	name:"应还总额",
			 	        	type:'bar',			 	   
			 	        	data:a.arr1
			 	        },
			 	        
			 	        {
			 	        	name:"实还总额",
			 	        	type:'bar',
			 	        	
			 	        	data:a.arr2
			 	        },
				 	       
				 	       {
			 	        	name:"提前或准时还总额",
			 	        	type:'bar',
			 	        	
			 	        	data:a.arr3
			 	        },
				 	       {
			 	        	name:"逾期已还总额",
			 	        	type:'bar',
			 	        	
			 	        	data:a.arr4
			 	        },
				 	       {
			 	        	name:"隔天应垫总额",
			 	        	type:'bar',
			 	        	
			 	        	data:a.arr5
			 	        },
				 	       {
			 	        	name:"30天应垫总额",
			 	        	type:'bar',
			 	        	
			 	        	data:a.arr6
			 	        },
				 	       {
			 	        	name:"60天应垫总额",
			 	        	type:'bar',
			 	        	
			 	        	data:a.arr7
			 	        },
				 	       {
			 	        	name:"90天应垫总额",
			 	        	type:'bar',
			 	        	
			 	        	data:a.arr8
			 	        }
			 	        
			 	        ]
			         });	
					
				}
			})
		})
		$(function(){
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
