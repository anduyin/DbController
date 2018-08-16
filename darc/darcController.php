<?php
/* 应收账款表格(存管)图处理数据文件
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */
require_once '../Common.php'; 

$date  = $_POST[0];
$query = "select * from data_accounts_receivable_cg where status_time=\"$date\"";
$result = mysqli_query($link, $query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
mysqli_close($link);
for($i=0;$i<count($arr);$i++){
    $arr[$i]['total_amount']=number_format((($arr[$i]['total_amount'])/10000),2,'.','');
    $arr[$i]['ture_total_amount']=number_format((($arr[$i]['ture_total_amount'])/10000),2,'.','');
    $arr[$i]['Advance_money']=number_format((($arr[$i]['Advance_money'])/10000),2,'.','');
    $arr[$i]['overdue_ture_repay_money']=number_format((($arr[$i]['overdue_ture_repay_money'])/10000),2,'.','');
    $arr[$i]['not_repay_money']=number_format((($arr[$i]['not_repay_money'])/10000),2,'.','');
    $arr[$i]['advance_payment_1']=number_format((($arr[$i]['advance_payment_1'])/10000),2,'.','');
    $arr[$i]['advance_payment_30']=number_format((($arr[$i]['advance_payment_30'])/10000),2,'.','');
    $arr[$i]['advance_payment_60']=number_format((($arr[$i]['advance_payment_60'])/10000),2,'.','');
    $arr[$i]['advance_payment_90']=number_format((($arr[$i]['advance_payment_90'])/10000),2,'.','');
    $arr[$i]['recover_1']=number_format((($arr[$i]['recover_1'])/10000),2,'.','');
    $arr[$i]['recover_30']=number_format((($arr[$i]['recover_30'])/10000),2,'.','');
    $arr[$i]['recover_60']=number_format((($arr[$i]['recover_60'])/10000),2,'.','');
    $arr[$i]['recover_90']=number_format((($arr[$i]['recover_90'])/10000),2,'.','');
}
//var_dump($arr);
echo  json_encode($arr); 
//echo $query;
