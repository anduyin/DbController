<?php
session_start();
if($_SESSION['status']==0){
 	header("Location: Login.html");
}
//把文件目录里的所有文件名导出 
$dir  =  "/var/www/html/php7.thinkcmf.com/pic/smjg";//文件目录

 //判断目标目录是否是文件夹
 $d = "http://47.97.9.93:1050/pic/smjg";
        $pic_arr = array();
        if(is_dir($dir)){
            //打开
            if($dh = @opendir($dir)){
                //读取
                while(($pic = readdir($dh)) !== false){

                    if($pic != '.' && $pic != '..'){
						if(substr($pic,-3)=='png'){
							$pic_arr[] = $d.'/'.$pic;
						}
                    }
                }
                //关闭
                closedir($dh);
            }
            krsort($pic_arr);
}
header("Cache-Control: no-cache, must-revalidate");
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
	
</style>
</head>
<body>
	<div>
		<?php foreach($pic_arr as $v){?>
			<div style="display: inline-block;width: 800px;"><img style="width:800px;" src="<?php echo $v;?>"/></div>
		<?php }?>
	</div>	
</body>
</html>
