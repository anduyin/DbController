<?php
/* 登录处理脚本
 * 验证输入是否正确
 *  */
$lifeTime = 24 * 3600; 
session_set_cookie_params($lifeTime);
//session_start();
$username = $_POST[0];
$password = md5(trim($_POST[1]));
require_once 'Common.php'; 
$sql = 'select * from user where name= ? and password= ?';
$stmt=$pdo->prepare($sql);
$bool = $stmt->execute(array($username,$password));
$result = $stmt->fetchAll();
if($bool){
 	$_SESSION['username']=$username;
 	$_SESSION['status']=$result[0]['status'];
 	$_SESSION['permission'] = $result[0]['permission'];
	echo "ok";
}else{
	echo "error";
}  

