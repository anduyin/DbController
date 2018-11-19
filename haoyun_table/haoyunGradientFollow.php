<?php

require_once '../Common.php';
require_once '../main.php';
$main = new main();
//查询最新一天
$time_sql= "SELECT update_date FROM `haoyun_gradient_follow` ORDER BY create_time DESC limit 1";
$time_res = mysqli_query($link,$time_sql);
$time = $time_res->fetch_all(MYSQLI_ASSOC);
$head = $main->getColumnComment($link,'haoyun_gradient_follow');
$query = "SELECT `admin_real_name`,
	from_unixtime(create_time) as `create_time`,
	from_unixtime(update_time) as `update_time`,
	`gradient`,
	`gradient_title`,
	`update_date` FROM `haoyun_gradient_follow` WHERE  update_date = '{$time[0]['update_date']}' ORDER BY create_time DESC ";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
//获取梯度
$sql = "select gradient_title,gradient from `haoyun_gradient_follow` group by gradient";
$execSql = mysqli_query($link,$sql);
$title = $execSql->fetch_all(MYSQLI_ASSOC);
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

        #example {
            margin-left:300px;
        }
        .search {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>梯度按跟进时间排序表</title>
    <script src="../jquery-3.2.1.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="../handsontable-pro-master/dist/handsontable.full.min.js"></script>
    <link href="../handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">

</head>
<body style="background-color:#fff;">

<div style="text-align: center" class="top">
    <span style="font-size:18px;color:#262626;float:left;margin-left:25px;">龙分期></span>
    <span style="font-size:18px;color:#F44B2A;float:left;">梯度按跟进时间排序表</span>
</div>
<form action="" id = 'formDate' name="formDate">
    <input type="hidden" value="haoyun_gradient_follow" name="code">
    <div class="search">
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
<div id="example" class="moneyTable"></div>


</body>
<script type="text/javascript">
    var data = <?php echo $json;?>;
    var container = document.getElementById('example');
    var hot = new Handsontable(container, {
        data: data,
        rowHeaders: true,
        colHeaders: <?php echo $headjson?>,
        colWidths: [120,130,130,80,1100,120],
        filters: true,
        dropdownMenu: true,
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
        exportPlugin.downloadFile('csv', {filename: '梯度按跟进时间排序表'});
    })

    //查询
    selectTotal = function (){
        var info = $("#formDate").serialize();
        $.ajax({
            url:"haoyunController.php",
            type:"post",
            data:info,
            success:function(re){
                var result = JSON.parse(re);
                hot.updateSettings({
                    data: result.data
                });

            }
        });
    }

    $('#search').click(function(){
        selectTotal();
    })


</script>
</html>