<?php
//初始化
$ch = curl_init("http://other2.xiaoshupuhui.com/api/XiaoShu/GetUserInfo");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS,$Send);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($Send)
));

$result = curl_exec($ch);

if (curl_errno($ch)) {
    print curl_error($ch);
}
curl_close($ch);
echo $result;
     