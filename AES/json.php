<?php
require_once 'Openssl.php';//引入加密类
$key = "IHRHGBLK7SJASFTT"; //密钥
$telno =  $_POST['telno'];//获取输入的手机号
//$telno = "17620304149";
$arr = array();
$arr["telno"] = $telno;
$arr["real"]  = 1;
$arr["sesame"]= 1;
$arr["family"]= 1;
$arr["work"]  = 1;
$arr["rong360"]=1;
$arr["mail"] = 1;
$arr["tongdun"] =1;
$json = json_encode($arr); //转为需要的json
$s = new OpenSSLAES($key);
$data = $s->encrypt($json);
$Token["Token"] = $data;
$Send = json_encode($Token);//按格式转json
require_once 'curl.php';
?>