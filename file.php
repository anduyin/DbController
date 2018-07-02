<?php
/* session_start();
 if($_SESSION['status']==0){
 	header("Location: Login.html");
} */
//把文件目录里的所有文件名导出 
$dir  =  "/bigdata/扫描结果";//文件目录
 //判断目标目录是否是文件夹
        $file_arr = array();
        if(is_dir($dir)){
            //打开
            if($dh = @opendir($dir)){
                //读取
                while(($file = readdir($dh)) !== false){

                    if($file != '.' && $file != '..'){
						if(substr($file,-3)=='zip'){
							$file_arr[] = $file;
						}
                    }
                }
                //关闭
                closedir($dh);
            }
}
?>
<!DOCTYPE html>
<html>
<head>
<script src="jquery-3.2.1.min.js"></script>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<style>
	body{
			font-size:18px;
	}
	span{
			margin:0 5px;
	}
</style>
</head>
<body>
	<div>
		<ul class="list-group">
			<?php foreach($file_arr as $file){?>
			<li class="list-group-item">&nbsp;<a href="filedownload.php?dir=<?php echo $dir?>&filename=<?php echo $file?>"><span class="glyphicon glyphicon-save"></span><?php echo $file?></a></li>
			<?php }?>
		</ul>
	</div>	
</body>
</html>
