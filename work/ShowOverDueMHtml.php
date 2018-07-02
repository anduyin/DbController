<?php
session_start();
if($_SESSION['status']==0){
	echo "您没有权限查看";
	header("Location: /Login.html");
}
include "./ShowOverDueM.php";
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
<title>周表</title>
<!-- <script src="http://47.97.9.93/jquery-3.2.1.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="http://47.97.9.93/bootstrap/js/bootstrap.min.js"></script>
<link href="http://47.97.9.93/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

<div class="form-group">
<form  action="./DownOverDueM.php" id="downXls">
<!-- <input type="submit" id="submit" value="下载" /> -->
<button type="submit" style="margin-left:3%" class="btn btn-default">下载XLS表格</button>
</form>
</div>




<!-- 用本地的测试js文件 -->
<script src="./jquery-3.2.1.min.js"></script>
<script src="./bootstrap.min.js"></script>
<link href="./bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
//逾期表
ShowOverdueM::outTableHtml();
?>
</div>
</body>
</html>
