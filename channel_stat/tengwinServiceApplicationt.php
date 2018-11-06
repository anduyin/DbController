<?php
/**
 * Created by PhpStorm.
 * User: 89171
 * Date: 2018/11/5
 * Time: 10:25
 */

require_once '../Common.php';
require_once '../main.php';
$main = new main();
$page = 1;
$pageSize = 100;
$index = ($page-1)*$pageSize;
$field = $main->getColumnName($link,'tengwin_service_application');
$head = $main->getColumnComment($link,'tengwin_service_application');
$query = "SELECT {$field} FROM `tengwin_service_application` ORDER BY registration_time DESC limit {$index} , {$pageSize}";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
//计算总服务金额
$total_sql = "SELECT COALESCE(sum(amount),0) as total FROM `tengwin_service_application`";
$result_total = mysqli_query($link, $total_sql);
$total_money = $result_total->fetch_assoc();
//查询总数
$totalSql = 'select count(*) from `tengwin_service_application`';
$totalRe = mysqli_query($link,$totalSql);
$num = $totalRe->fetch_row();
$max = ceil($num[0]/$pageSize);
//查询分组
$groupSql = 'select group_name from `tengwin_service_application` GROUP By group_name';
$result_group = mysqli_query($link,$groupSql);
$group = $result_group->fetch_all(MYSQLI_ASSOC);
//查询分部
$serviceSql = 'select service_center_name from `tengwin_service_application` GROUP By service_center_name';
$result_service = mysqli_query($link,$serviceSql);
$service = $result_service->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
$headjson = json_encode($head);
$json = json_encode($arr);
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

        #example,#formDate,#money {
            margin-left:200px;
        }


    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>服务申请列表</title>
    <script src="../jquery-3.2.1.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="../handsontable-pro-master/dist/handsontable.full.min.js"></script>
    <link href="../handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">

</head>
<body style="background-color:#fff;">

<div style="text-align: center" class="top">
    <span style="font-size:18px;color:#262626;float:left;margin-left:25px;">龙分期></span>
    <span style="font-size:18px;color:#F44B2A;float:left;">服务申请列表</span>
</div>
<form action="" id = 'formDate' name="formDate">
    <input type="hidden" value="tengwin_service_application" name="code">

<div>
    付款单号:<input type="text" name = 'serial_num' value="" placeholder="付款单号">
    姓名:<input type="text" name = 'electrical_name' value="" placeholder="姓名">
    支付时间:<input type="date" value="" id = "pay_time_start">&nbsp;&nbsp;至&nbsp;&nbsp;&nbsp;<input type="date" value="" id = "pay_time_end">
    是否支付:<select name="status">
                <option value="-1">所有</option>
                <option value="0">未支付</option>
                <option value="1">已支付</option>
            </select>
    分部:<select name="service_center_name">
            <option value="-1">所有分部</option>
            <?php foreach($service as $value){?>
                <option value="<?php echo $value['service_center_name'];?>"><?php echo $value['service_center_name'];?></option>
            <?php }?>
        </select>
    分组:<select name="group_name">
            <option value="-1">所有分组</option>
            <?php foreach($group as $value){?>
            <option value="<?php echo $value['group_name'];?>"><?php echo $value['group_name'];?></option>
            <?php }?>
        </select>
    </div>
    <div>
    业务员:<input type="text" value="" name="customer_user" placeholder="请输入业务员姓名">
    转化人员:<input type="text" value="" name="transfer_user" placeholder="请输入转化人员姓名">
    注册时间:<input type="date" value="" id = "registration_time_start">&nbsp;&nbsp;至&nbsp;&nbsp;&nbsp;<input type="date" value="" id = "registration_time_end">
    渠道来源:<input type="text" value="" name="agent_name" placeholder="请输入渠道来源">
    渠道推荐人:<input type="text" value="" name="channel_name" placeholder="请输入渠道推荐人">
        <input type='button' value="下载" class="btn" id="download">
        <input type="button" value="查询" id = "search" class="btn">
    </div>



</form>
<div id="money">
    <span>服务总金额:</span>
    <span id="total_money"><?php echo $total_money['total'].'元';?></span>
</div>
<div id="example" class="moneyTable"></div>
<div id = page>
    <nav aria-label="...">
        <ul class="pager">
            <li><a href="#" id = "proPage">上一页</a></li>
            <input type="text" value="<?php echo $page ?>" id="pageFee" name="page">/<span id="max"><?php echo $max; ?></span>
            <button id="jump" class="btn btn-default">跳转</button>
            <li><a href="#" id="nextPage">下一页</a></li>
        </ul>
    </nav>
</div>


</body>
<script type="text/javascript">
    var data = <?php echo $json;?>;
    var container = document.getElementById('example');
    var hot = new Handsontable(container, {
        data: data,
        rowHeaders: false,
        colHeaders: <?php echo $headjson?>,
        colWidths: 120,
        filters: true,
        dropdownMenu: false,
        manualColumnFreeze: true,
        forceNumeric: true,
        manualColumnResize: true,
        sortIndicator: true,
        columnSorting: true,
        readOnly:true,
        fixedRowsBottom: 2
    });

    var exportPlugin = hot.getPlugin('exportFile');
    $("#download").click(function(){
        hot.alter('insert_row', 0);
        var head = <?php echo $headjson?>;
        var headInfo = [];
        for(var h=0;h<head.length;h++){
            headInfo[h] = [0,h,head[h]];
        }
        hot.setDataAtCell(headInfo);
        exportPlugin.downloadFile('csv', {filename: '服务申请列表'});
    })
    //查询
    selectTotal = function (page,pageSize){
        var info = $("#formDate").serialize();
        var page = page || 1;
        var pageSize = pageSize || 100;
        var pay_time_start = $('#pay_time_start').val();
        var pay_time_end = $('#pay_time_end').val();
        var registration_time_start = $('#registration_time_start').val();
        var registration_time_end = $('#registration_time_end').val();
        info = info +"&"+"page="+page;
        info = info +"&"+"pageSize="+pageSize;
        info = info +"&"+"pay_time_start="+pay_time_start;
        info = info +"&"+"pay_time_end="+pay_time_end;
        info = info +"&"+"registration_time_start="+registration_time_start;
        info = info +"&"+"registration_time_end="+registration_time_end;
        $.ajax({
            url:"tengwinController.php",
            type:"post",
            data:info,
            success:function(re){
                var result = JSON.parse(re);
                var nowPage = result.page;
                var max = result.max;
                var total_money = result.totalMoney;
                $("#pageFee").val(nowPage);
                $("#max").text(max);
                $('#total_money').empty();
                $('#total_money').html(total_money+'元');
                console.log(result);
                hot.updateSettings({
                    data: result.data
                });
            }
        });
    }

    $("#nextPage").click(function(){
        var nextPage = Number($("#pageFee").val()) + 1;
        var maxN = $("#max").text();
        if(nextPage>maxN){
            nextPage = maxN;
        }
        selectTotal(nextPage);
    });
    $("#proPage").click(function(){
        var proPage = $("#pageFee").val() - 1;
        if(proPage<=0){
            proPage = 1;
        }
        selectTotal(proPage);
    })
    $("#jump").click(function(){
        var jumpPage = $("#pageFee").val();
        var reg=/^[0-9]+.?[0-9]*$/
        var maxN = $("#max").text();
        if(!reg.test(jumpPage)){
            alert('错误,输入的页数有误');
        }
        if(jumpPage == 0){
            jumpPage = 1;
        }
        if(jumpPage>maxN){
            jumpPage = maxN;
        }
        selectTotal(jumpPage);
    })

    $('#search').click(function(){
        selectTotal();
    })




</script>
</html>