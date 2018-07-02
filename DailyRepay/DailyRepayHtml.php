<?php
include "./DailyRepay.php";
$start = isset($_POST['start']) ? $_POST['start']: "";
$end = isset($_POST['end']) ? $_POST['end']: "";
?>
<html>
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
		text-align: center;
	}
	.top{
		height:50px;
		line-height:50px;
	}
	.one{
		background-color:#87818F;
	}
	#t{
		padding:0 25px;
	}
	.title{
		margin-bottom:10px;
	}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>应还金额表</title>
<!-- <script src="http://47.97.9.93/jquery-3.2.1.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="http://47.97.9.93/bootstrap/js/bootstrap.min.js"></script>
<link href="http://47.97.9.93/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

<!-- 用本地的测试js文件 -->
<script src="./jquery-3.2.1.min.js"></script>
<script src="./bootstrap.min.js"></script>
<link href="./bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div  hidden id="alertNotice" class="alert alert-warning">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<strong>错误！</strong>开始日期和结束日期不能只填一个。
</div>
<?php
//输出html
DailyRepay::outHtmlTable($start, $end);
?>
<script>
	//用注册事件的方法判断两个日期是否为空
	$("#query").click(function () {
		var s = $("#start").val();
		var e = $("#end").val();
		//Xor的逻辑操作
		if (s ? !e :e) {
			$("#alertNotice").show();
			return false;
		} else {
			document.getElementById("repayDate").submit()
			// return true;
		}

	});

</script>
</div>
</body>
</html>
