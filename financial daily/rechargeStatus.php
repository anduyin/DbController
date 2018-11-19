<?php
/**
 * Created by PhpStorm.
 * User: 89171
 * Date: 2018/8/27
 * Time: 11:35
 */
require_once '../Common.php';
$query = "SELECT * FROM `xssd_recharge_status` ORDER BY create_time DESC ";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
$head = array('日期','申请充值笔数','成功充值笔数','申请充值金额','成功充值金额','成功提现金额','成功提现笔数');
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
    <title>放款与服务费</title>
    <script src="../jquery-3.2.1.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="../handsontable-pro-master/dist/handsontable.full.min.js"></script>
    <link href="../handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">

</head>
<body style="background-color:#fff;">

<div style="text-align: center" class="top">
    <span style="font-size:18px;color:#262626;float:left;margin-left:25px;">理财端日报></span>
    <span style="font-size:18px;color:#F44B2A;float:left;">充值及提现金额</span>
</div>
<div class="search">
    <input type='button' value="下载" class="btn" id="download">
</div>
<div id="example" class="moneyTable"></div>


</body>
<script type="text/javascript">
    var data = <?php echo $json;?>;
    var container = document.getElementById('example');
    var hot = new Handsontable(container, {
        data: data,
        rowHeaders: true,
        colHeaders: <?php echo $headjson?>,
        colWidths: 150,
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
        exportPlugin.downloadFile('csv', {filename: '充值及提现金额'});
    })




</script>
</html>