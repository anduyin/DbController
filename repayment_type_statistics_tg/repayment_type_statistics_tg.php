<?php
/* 存管收费数据表展示文件
 *  */
	require_once '../Common.php';
	$page = 1;
	$pageSize = 30;
	$index = ($page-1)*$pageSize;
	$now = date('Y-m-d',time());
	$start = date('Y-m-d',(time()-7*24*60*60));
	$query = "SELECT * FROM `repayment_type_statistics_tg` where date >=".'\''.$start.'\''." and date <=".'\''.$now.'\''." and type = '用户还款' limit " .$index.','.$pageSize;//首次打开,显示30条
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
    //全部还款类型
    $nameSql = "SELECT `type` FROM `repayment_type_statistics_tg` GROUP BY `type`";
	$nameRe = mysqli_query($link, $nameSql);
	$name = $nameRe->fetch_all(MYSQLI_ASSOC);
    //查询总数
    $totalSql = "SELECT count(*) FROM `repayment_type_statistics_tg` where date >=".'\''.$start.'\''." and date <=".'\''.$now.'\''." and type = '用户还款'";
    $totalRe = mysqli_query($link,$totalSql);
    $num = $totalRe->fetch_row();
    $max = ceil($num[0]/$pageSize);
	mysqli_close($link);
	$head = array('ID','日期','还款类型','人数','金额');
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
		.active{
			text-align: right;
			padding: 8px;
			line-height: 1.42857143;
			vertical-align: top;
			background-color: #f5f5f5;
			font-size: 14px;
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
		.title{
			margin-bottom:10px;
			
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
		.href {
			color: #337ab7;
			text-decoration: none;
			font-size: 14px;
		}
		#example {
			margin-left:300px; 
		}
		#money {
			width:70px;
		}
		.foot {
			text-align: center;
			width: 1500px;
			height:50px;
			line-height:50px;
		}
		
		.recharge {
			text-align: center;
			margin-bottom: 10px;
		}
		.search {
			text-align: center;
			margin-bottom: 10px;
		}
        #pageFee {
            width:50px;
        }
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>还款类型统计(托管)</title>
	<script src="../jquery-3.2.1.min.js"></script>
	<script src="../handsontable-pro-master/dist/handsontable.full.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="../handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


</head>
<body style="background-color:#fff;">

	<div style="text-align: center" class="top">
		<span style="font-size:18px;color:#262626;float:left;margin-left:25px;">数据表 > </span>
        <span style="font-size:18px;color:#F44B2A;float:left;">还款类型统计(托管)</span>
    </div>
		<div class="search">
            <!--筛选条件：贷款类型，放款状态，放款日，结清日，是否超36,共5个，“是否超36”需显示为是否。-->
            <!-- 贷款类型 -->
            还款类型:
            <select id = "name">
                    <option value = "-1">全部</option>
                <?php foreach($name as $v){?>
                    <option value = "<?php echo $v['type']?>"><?php echo $v['type']?></option>
                <?php }?>
            </select>
            <!-- 贷款类型 End-->
            <!--日期-->
            日期:
			<input type="date" value="" id = "date1">
			&nbsp;&nbsp;至&nbsp;&nbsp;
			<input type="date" value="" id = "date2">
            <!--日期 End-->
			<input type="button" value="查询" id = "searchTotal" class="btn">
			<input type='button' value="下载" class="btn" id="download">
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
	<div id='total'></div>
</body>
<script type="text/javascript">
    $(function(){
        var data = <?php echo $json;?>;
        var container = document.getElementById('example');
        var hot = new Handsontable(container, {
            data: data,
            rowHeaders: true,
            colHeaders: <?php echo $headjson?>,
            colWidths: 230,
            filters: true,
            dropdownMenu: true,
            manualColumnFreeze: true,
            forceNumeric: true,
            manualColumnResize: true,
            sortIndicator: true,
            columnSorting: true,
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
            exportPlugin.downloadFile('csv', {filename: '还款类型统计(托管)'});
        });

        //查询
        selectTotal = function (page,pageSize){
            var info={};
            var name = $("#name").val();
            var loan_date1 = $("#date1").val();
            var loan_date2 = $("#date2").val();
            var page = page || 1;
            var pageSize = pageSize || 30;
            info['name'] = name;
            info['date1'] = loan_date1;
            info['date2'] = loan_date2;
            info['code'] = 'searchTotal';
            info['page'] = page;
            info['pageSize'] = pageSize;
            console.log(info);
            $.ajax({
                url:"repayment_type_statistics_tg_controller.php",
                type:"post",
                data:info,
                success:function(re){
                    var result = JSON.parse(re);
                    var nowPage = result.page;
                    var max = result.max;
                    $("#pageFee").val(nowPage);
                    $("#max").text(max);
                    console.log(result);
                    hot.updateSettings({
                        data: result.data
                    });
                }
            });
        }
        $("#searchTotal").click(function(){
            selectTotal();
        })
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
    })
</script>
</html>
