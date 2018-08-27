<?php
/**
 * Created by PhpStorm.
 * User: 89171
 * Date: 2018/8/27
 * Time: 11:56
 */
require_once 'Common.php';
$name = $_SESSION['username'];
$time = date('Y-m-d H:i:s',time());
?>
<html>
<head>
    <meta charset="utf-8">
    <title>后台首页</title>
</head>
<body>
    <div>
        <h1>欢迎登陆,<?PHP echo $name?></h1>
        <h2>登陆时间<?php echo $time?></h2>
    </div>
</body>
</html>
