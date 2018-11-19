<?php

require_once '../Common.php';
//获得分配梯度统计(数量版)
$field_num = "create_date,assignment,follow,deal,follow_deal,pay,front_end_income,back_end_income";
$query_num = "SELECT {$field_num} FROM `haoyun_assign_gradient_statistics` ORDER BY create_date DESC ";
$result_num = mysqli_query($link, $query_num);
$arr_num = $result_num->fetch_all(MYSQLI_ASSOC);
$head_num = ['分配日期','分配数','跟进数','成交数','跟进成交数','下款数','前端营收','后端营收'];
$headjson_num = json_encode($head_num);
$json_num = json_encode($arr_num);
//分配梯度统计(百分比版)
$field_per = "create_date,follow_rate,deal_rate,follow_deal_rate,pay_rate";
$query_per = "SELECT {$field_per} FROM `haoyun_assign_gradient_statistics` ORDER BY create_date DESC ";
$result_per = mysqli_query($link, $query_per);
$arr_per = $result_per->fetch_all(MYSQLI_ASSOC);
$head_per = ['分配日期','跟进率','成交率','跟进成交率','下款率'];
$headjson_per = json_encode($head_per);
$json_per = json_encode($arr_per);
//获取梯度
$sql = "select gradient_title,gradient from `haoyun_assign_gradient_statistics` group by gradient";
$execSql = mysqli_query($link,$sql);
$title = $execSql->fetch_all(MYSQLI_ASSOC);

mysqli_close($link);
?>
<!DOCTYPE html>
<html style="position: absolute; left: 0; top: 0;">
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

        .top{
            width: 1500px;
            height:50px;
            line-height:50px;
        }
        select{
            height:34px;
            width:100px;
            text-align:center;
        }

        .btn {

            height: 34px;
            color: #fff;
            background-color: #337ab7;
            border: 1px solid #2e6da4;
            border-radius: 4px;
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
        }

        #example_num,#example_per {
            margin-left:200px;
        }
        .search {
            margin-left:200px;
            margin-bottom: 10px;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>分配梯度统计</title>
    <script src="../jquery-3.2.1.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="../handsontable-pro-master/dist/handsontable.full.min.js"></script>
    <link href="../handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">

</head>
<body style="background-color:#fff;">

<div style="text-align: center" class="top">
    <span style="font-size:18px;color:#262626;float:left;margin-left:25px;">龙分期></span>
    <span style="font-size:18px;color:#F44B2A;float:left;">分配梯度统计</span>
</div>
<form action="" id = 'formDate' name="formDate">
    <input type="hidden" value="haoyun_assign_gradient_statistics" name="code">
<div class="search">
    时间范围:
    <input type="date" value="" id = "create_date_start">&nbsp;&nbsp;至&nbsp;&nbsp;&nbsp;<input type="date" value="" id = "create_date_end">
    梯度:
    <select name="gradient" id="gradient_title">
        <option value="-1">全部梯度</option>
        <?php foreach($title as $k=>$v){?>
            <option value="<?php echo $v['gradient']?>"><?php echo $v['gradient_title']?></option>
        <?php }?>
    </select>
    <input type='button' value="查询" class="btn" id="search">
    <input type='button' value="下载" class="btn" id="download">
</div>
</form>
<h2>分配梯度统计(数量版)</h2>
<div id="example_num" class="moneyTable"></div>
<h2>分配梯度统计(百分比版)</h2>
<div id="example_per" class="moneyTable"></div>


</body>
<script type="text/javascript">
    var data_num = <?php echo $json_num;?>;
    var container_num = document.getElementById('example_num');
    var hot_num = new Handsontable(container_num, {
        data: data_num,
        rowHeaders: false,
        colHeaders: <?php echo $headjson_num?>,
        colWidths: 120,
        filters: true,
        dropdownMenu: false,
        manualColumnFreeze: true,
        forceNumeric: true,
        manualColumnResize: true,
        sortIndicator: true,
        readOnly:true,
        columnSorting: true,
        fixedRowsBottom: 2
    });

    var exportPlugin_num = hot_num.getPlugin('exportFile');
    $("#download").click(function(){
        hot_num.alter('insert_row', 0);
        var head = <?php echo $headjson_num?>;
        var headInfo = [];
        for(var h=0;h<head.length;h++){
            headInfo[h] = [0,h,head[h]];
        }
        hot_num.setDataAtCell(headInfo);
        exportPlugin_num.downloadFile('csv', {filename: '分配梯度统计(数量版)'});
    })

    var data_per = <?php echo $json_per;?>;
    var container_per = document.getElementById('example_per');
    var hot_per = new Handsontable(container_per, {
        data: data_per,
        rowHeaders: false,
        colHeaders: <?php echo $headjson_per?>,
        colWidths: 120,
        filters: true,
        dropdownMenu: false,
        manualColumnFreeze: true,
        forceNumeric: true,
        manualColumnResize: true,
        sortIndicator: true,
        readOnly:true,
        columnSorting: true,
        fixedRowsBottom: 2
    });

    var exportPlugin_per = hot_per.getPlugin('exportFile');
    $("#download").click(function(){
        hot_per.alter('insert_row', 0);
        var head = <?php echo $headjson_per?>;
        var headInfo = [];
        for(var h=0;h<head.length;h++){
            headInfo[h] = [0,h,head[h]];
        }
        hot_per.setDataAtCell(headInfo);
        exportPlugin_per.downloadFile('csv', {filename: '分配梯度统计(百分比版)'});
    })

    //查询
    selectTotal = function (){
        var info = $("#formDate").serialize();
        var create_date_start = $('#create_date_start').val();
        var create_date_end = $('#create_date_end').val();
        info = info +"&"+"create_date_start="+create_date_start;
        info = info +"&"+"create_date_end="+create_date_end;
        $.ajax({
            url:"haoyunController.php",
            type:"post",
            data:info,
            success:function(re){
                var result = JSON.parse(re);
                //console.log(re);
                var dataNum = result['dataNum'];
                var dataPer = result['dataPer'];
                hot_num.updateSettings({
                    data: dataNum
                });
                hot_per.updateSettings({
                    data: dataPer
                });
            }
        });
    }

    $('#search').click(function(){
        selectTotal();
    })





</script>
</html>