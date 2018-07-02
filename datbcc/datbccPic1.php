<?php
/* 利息金额柱形图展现文件(存管)
 * 逾期率图
 * 一开始并没有
 * 需要自己选择条件显示
 *  
 *  */
require_once '../Common.php';
$query = "select status_time from data_amount_to_be_collected_cg group by status_time order by status_time desc";
$result = mysqli_query($link, $query);
$time = $result->fetch_all(MYSQLI_ASSOC);
$timeFirst = $time[0]["status_time"];
require_once 'datbccEdit.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>周表</title>
<script src="../jquery-3.2.1.min.js"></script>
<script src="../echarts.js"></script>
</head>
<body>
	<div>
	<a href="datbcc.php">返回表格图</a>
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
	var arr1=[],arr2=[],arr3=[],arr4=[];
	for(var i in arr){
		arr1.push(arr[i]['repay_money']);
		arr2.push(arr[i]['self_money']);
		arr3.push(arr[i]['interest_money']);
		arr4.push(arr[i]['repay_date']);
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
		title:{text:'利息金额'
		},
		tooltip:{trigger: 'axis'},
		
		legend: {
			data:["待收本息","待收本金","待收利息"]
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
        	data:b.arr4
        	},
        yAxis:{
        	name:'金额(万元)'
        },
        
        series:[
        
        {
        	name:"待收本息",
        	type:'bar',
        	barMaxWidth:100,
        		
        	data:b.arr1
        },
        
        {
        	name:"待收本金",
        	type:'bar',
        	barMaxWidth:100,
        	
        	data:b.arr2
        },
	       
	       {
        	name:"待收利息",
        	type:'bar',
        	barMaxWidth:100,
        	
        	data:b.arr3
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
				url:"datbccEdit.php",
				data:data,
				type:"post",
				success:function(re){
					var a=getDom(re);
					myChart.setOption({
			        	 title:{text:'利息金额'
			 			},
			 			tooltip:{trigger: 'axis'},
			 			
			 			legend: {
			 				data:["待收本息","待收本金","待收利息"]
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
			 	        	data:a.arr4
			 	        	},
			 	        yAxis:{
			 	        	name:'金额(万元)'
			 	        },
			 	        
			 	        series:[
			 	        
			 	        {
			 	        	name:"待收本息",
			 	        	type:'bar',
			 	        	barMaxWidth:100,
			 	        		
			 	        	data:a.arr1
			 	        },
			 	        
			 	        {
			 	        	name:"待收本金",
			 	        	type:'bar',
			 	        	barMaxWidth:100,
			 	        	
			 	        	data:a.arr2
			 	        },
				 	       
				 	       {
			 	        	name:"待收利息",
			 	        	type:'bar',
			 	        	barMaxWidth:100,
			 	        	
			 	        	data:a.arr3
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
