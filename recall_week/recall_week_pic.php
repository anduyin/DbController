<?php
/* 回溯表T+0折线图图展现文件
 * 每周逾期率记录(回溯版)
 *  */
session_start();
if($_SESSION['status']==0){
        echo "您没有权限查看";
        header("Location: Login.html");
}
require_once 'recall_week_edit.php';
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
        <a href="recall_week.php">返回表格图</a>
        <form action="" method="post">
        <!-- 时间选项 -->
        <input type="date" value="" id = "time1">
        &nbsp;&nbsp;至&nbsp;&nbsp;
        <input type="date" value="" id = "time2">
        <input type="button" value="查询" id="button" class="btn btn-primary">
        <span id='tip'>时间范围请选择1个月,以免显示不全</span>
        </form>
        </div>
        <div style="width:1600px;height:800px" id="main">
<script>
/* 功能:获取展示折线图的数组
   param: re 从ajax回传来的json
   return: array 数组
*/
function getDom(re){
        var arr = eval(re);
        var arr1=[],arr2=[],arr3=[],arr4=[],arr5=[],arr6=[];
        for(var i = 0;i < arr[0].length;i++){
            arr6[i] = arr[0][i]['status_time'];
        }
        var result = [];
    for(var a=0;a<arr.length;a++){
        for(var b=0;b<arr[0].length;b++){
        arr1.push(arr[a][b]["T+0overdue_ratio"]);
        arr3.push(arr[a][b]["field_value"]);
        }
        }
    var num = arr[0].length;
    var arr2 = group(arr1, num);
        var brr = {};
        brr['arr6'] = arr6;
        brr['arr2'] = arr2;
        brr['arr3'] = arr3;
        return  brr;
        }
/* 功能:按一定数量把一个数组分割为若干个子数组
param: array 需要分割的数组
       subGroupLength 需要分割的子数组元素个数
return: array 一个二维数组 */
function group(array, subGroupLength) {
    var index = 0;
    var newArray = [];
    while(index < array.length) {
        newArray.push(array.slice(index, index += subGroupLength));
    }
    return newArray;
}
var myChart = echarts.init(document.getElementById('main'));
var json = <?php echo $jsonfirst?>;
var b = getDom(json);
console.log(b);
myChart.setOption({
	title:{text:'每周逾期率记录(回溯版)'},
    tooltip:{trigger: 'axis'},
    legend: {
            data:b.arr3
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
    data:b.arr6
    },
yAxis:{
    name:'逾期率(%)'
},
series:[
{
    name:"工薪贷",
    type:'line',
    data:b.arr2[0]
},
   {
    name:"普惠-助薪贷",
    type:'line',
    data:b.arr2[1]
},
   {
    name:"白领贷",
    type:'line',
    data:b.arr2[2]
},
   {
    name:"考拉-优才贷",
    type:'line',
    data:b.arr2[3]
},
   {
    name:"总计",
    type:'line',
    data:b.arr2[4]
}
]
});
$("#button").click(function(){
        var data={};
        var time1 = $("#time1").val();
        var time2 = $("#time2").val();
        if((time1=="")||(time2=="")){
                alert("时间范围选择错误");
                return;
        }
        data[0] = time1;
        data[1] = time2;
        $.ajax({
                async : true,
                url:"recall_week_edit.php",
                data:data,
                type:"post",
                success:function(re){
                        var a=getDom(re);
                        myChart.setOption({
                         title:{text:'每周逾期率记录(回溯版)'},
                                tooltip:{trigger: 'axis'},
                                legend: {
                                        data:a.arr3
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
                                data:a.arr6
                                },
                        yAxis:{
                                name:'逾期率(%)'
                        },
                        series:[
                        {
                                name:"工薪贷",
                                type:'line',
                                data:a.arr2[0]
                        },
                               {
                                name:"普惠-助薪贷",
                                type:'line',
                                data:a.arr2[1]
                        },
                               {
                                name:"白领贷",
                                type:'line',
                                data:a.arr2[2]
                        },
                               {
                                name:"考拉-优才贷",
                                type:'line',
                                data:a.arr2[3]
                        },
                               {
                                name:"总计",
                                type:'line',
                                data:a.arr2[4]
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
