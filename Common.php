<?php
	session_start();
	if($_SESSION['status']==0){
 	header("Location: Login.html");
	} 

	/*$link = mysqli_connect('127.0.0.1','root','RFO9oYkjb^nNgXuE','xssdstat',3306);
	if(!$link){
		echo "失败";exit;
	}
	$pdo=new PDO('mysql:host=127.0.0.1;dbname=xssdstat','root','RFO9oYkjb^nNgXuE');*/
	//本地测试用
	$link = mysqli_connect('127.0.0.1','root','root','test',3306);
	if(!$link){
		echo "失败";exit;
	}
	
	$pdo=new PDO('mysql:host=127.0.0.1;dbname=test','root','root');
?>