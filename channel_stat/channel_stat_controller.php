<?php
/* 渠道统计
 * 处理Ajax过来的数据
 * 返回json
 *  
 *  */

require_once '../Common.php';
require_once '../main.php';
//查询(明细项)
function searchDate($link){
    $main = new main();
    $fleid = $main->getColumnName($link,'channel_stat');
	$time1 = $_POST[0];
	$time2  = $_POST[1];
	if($time1==$time2){
		$query = "SELECT {$fleid} FROM `channel_stat` where date = \"$time1\" order by `date` desc";
	}else{
		$query = "SELECT {$fleid} FROM `channel_stat` where date >= \"$time1\" and date <= \"$time2\" order by `date` desc";
	}
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_NUM);
	mysqli_close($link);
	echo  json_encode($arr);
}


function searchDariyLicaiCauseDetailData($link){
    $main = new main();
    $fleid = $main->getColumnName($link,'dariy_licai_clause_detail');
    $time1 = $_POST[0];
    $time2  = $_POST[1];
    if($time1==$time2){
        $query = "SELECT {$fleid} FROM `dariy_licai_clause_detail` where true_repay_date = \"$time1\" order by `true_repay_date` desc";
    }else{
        $query = "SELECT {$fleid} FROM `dariy_licai_clause_detail` where true_repay_date >= \"$time1\" and true_repay_date <= \"$time2\" order by `true_repay_date` desc";
    }
    $result = mysqli_query($link, $query);
    $arr = $result->fetch_all(MYSQLI_NUM);
    mysqli_close($link);
    echo  json_encode($arr);
}

if($_POST&&$_POST[2]=='search'){
	searchDate($link);
}elseif($_POST&&$_POST[2]=='dariy_licai_clause_detail'){
    searchDariyLicaiCauseDetailData($link);
}
