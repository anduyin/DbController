<?php
//表格下载处理脚本(逾期分析专用)
require_once 'PHPExcel-1.8/Classes/xls1.php';
@$field = $_POST['field'];
@$time  = $_POST['time'];
@$loan_name = $_POST['loan_name'];
@$tmp = $_POST['tmp'];
require_once 'Common.php';
if($tmp == "逾期分析-金额-现状版(存管)"){
	$Xlsname = "逾期分析-金额-现状版(存管)".$time;
	$sqlName = " id,loan_name as '借款类型',field as '类别',field_value as '具体类别',borrow_selfmoney as '放款本金(万元)',loaning_selfmoney as '在贷本金(万元)',should_selfmoney as '总应收本金(万元)',overdue_selfmoney as '总应收未收本金(万元)',Totaloverdue_ratio as '总逾期率(%)',M1selfmoney as 'M1本金(万元)',M1overdue_ratio as 'M1逾期率(%)',M2selfmoney as 'M2本金(万元)',M2overdue_ratio as 'M2逾期率(%)',M3selfmoney as 'M3本金(万元)',M3overdue_ratio as 'M3逾期率(%)',Morethan_M4selfmoney as '坏账本金(万元)',Morethan_M4overdue_ratio as '坏账率 (%)',放款金额占比,update_time as '数据更新时间'";
	$query = "select".$sqlName."from overdue_analysis_current_plus_money_cg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	if($field =='还款压力'&&$loan_name=='总计'){
		$c = $arr[2];
		$arr[2] = $arr[3];
		$arr[3] = $arr[4];
		$arr[4] = $arr[5];
		$arr[5] = $c;
	}
	for($i=0;$i<count($arr);$i++){
		$arr[$i]['放款本金(万元)'] = number_format((($arr[$i]['放款本金(万元)'])/10000),2,'.','');
		$arr[$i]['在贷本金(万元)'] = number_format((($arr[$i]['在贷本金(万元)'])/10000),2,'.','');
		$arr[$i]['总应收本金(万元)'] = number_format((($arr[$i]['总应收本金(万元)'])/10000),2,'.','');
		$arr[$i]['总应收未收本金(万元)'] = number_format((($arr[$i]['总应收未收本金(万元)'])/10000),2,'.','');
		$arr[$i]['总逾期率(%)'] = number_format((($arr[$i]['总逾期率(%)'])*100),2,'.','');
		$arr[$i]['M1本金(万元)'] = number_format((($arr[$i]['M1本金(万元)'])/10000),2,'.','');
		$arr[$i]['M1逾期率(%)'] = number_format((($arr[$i]['M1逾期率(%)'])*100),2,'.','');
		$arr[$i]['M2本金(万元)'] = number_format((($arr[$i]['M2本金(万元)'])/10000),2,'.','');
		$arr[$i]['M2逾期率(%)'] = number_format((($arr[$i]['M2逾期率(%)'])*100),2,'.','');
		$arr[$i]['M3本金(万元)'] = number_format((($arr[$i]['M3本金(万元)'])/10000),2,'.','');
		$arr[$i]['M3逾期率(%)'] = number_format((($arr[$i]['M3逾期率(%)'])*100),2,'.','');
		$arr[$i]['坏账本金(万元)'] = number_format((($arr[$i]['坏账本金(万元)'])/10000),2,'.','');
		$arr[$i]['坏账率 (%)'] = number_format((($arr[$i]['坏账率 (%)'])*100),2,'.','');
		$arr[$i]['放款金额占比'] = number_format((($arr[$i]['放款金额占比'])*100),2,'.','');
		
	}
}elseif($tmp == "逾期分析-笔数-现状版(存管)"){
	$Xlsname = "逾期分析-笔数-现状版(存管)".$time;
	$sqlName = " id,loan_name as '借款类型',field as '类别',field_value as '具体类别',borrow_count as '放款本金(万元)',loaning_count as '在贷本金(万元)',should_count as '总应收本金(万元)',overdue_count as '总应收未收本金(万元)',Totaloverdue_ratio as '总逾期率(%)',M1count as 'M1本金(万元)',M1overdue_ratio as 'M1逾期率(%)',M2count as 'M2本金(万元)',M2overdue_ratio as 'M2逾期率(%)',M3count as 'M3本金(万元)',M3overdue_ratio as 'M3逾期率(%)',Morethan_M4count as '坏账本金(万元)',Morethan_M4overdue_ratio as '坏账率 (%)',repay_num_proportion as '放款笔数占比',update_time as '数据更新时间'";
	$query = "select".$sqlName."from overdue_analysis_current_plus_num_cg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		$arr[$i]['总逾期率(%)'] = number_format((($arr[$i]['总逾期率(%)'])*100),2,'.','');
		$arr[$i]['M1逾期率(%)'] = number_format((($arr[$i]['M1逾期率(%)'])*100),2,'.','');
		$arr[$i]['M2逾期率(%)'] = number_format((($arr[$i]['M2逾期率(%)'])*100),2,'.','');
		$arr[$i]['M3逾期率(%)'] = number_format((($arr[$i]['M3逾期率(%)'])*100),2,'.','');
		$arr[$i]['坏账率 (%)'] = number_format((($arr[$i]['坏账率 (%)'])*100),2,'.','');
		$arr[$i]['放款笔数占比'] = number_format((($arr[$i]['放款笔数占比'])*100),2,'.','');
	}
}elseif($tmp == "逾期分析-笔数-回溯版(存管)"){
	$Xlsname = "逾期分析-笔数-回溯版(存管)".$time;
	$sqlName = " id,loan_name as '贷款名称',field as '类别',field_value as '具体类别',`T+1overdue_ratio` as 'T+1逾期率(%)',`T+2overdue_ratio` as 'T+2逾期率(%)',`T+31overdue_ratio` as 'T+31逾期率(%)',`T+3overdue_ratio` as 'T+3逾期率(%)',`T+4overdue_ratio` as 'T+4逾期率(%)',`T+5overdue_ratio` as 'T+5逾期率(%)',`T+61overdue_ratio` as 'T+61逾期率(%)',`T+6overdue_ratio` as 'T+6逾期率(%)',`T+7overdue_ratio` as 'T+7逾期率(%)',`T+91overdue_ratio` as 'T+91逾期率(%)',should_num as '应还笔数(笔)',onday_ratio as '当天还款率(%)',prepay_ratio as '提前还款率(%)',repay_num as '放款笔数 (笔)',repay_num_proportion as '放款笔数占比',update_time as '数据更新时间'";
	$query = "select".$sqlName."from overdue_analysis_track_plus_num_cg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	if($field =='还款压力'&&$loan_name=='总计'){
		$c = $arr[2];
		$arr[2] = $arr[3];
		$arr[3] = $arr[4];
		$arr[4] = $arr[5];
		$arr[5] = $c;	
	}
	for($i=0;$i<count($arr);$i++){	
		$arr[$i]['T+1逾期率(%)'] = number_format((($arr[$i]['T+1逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+2逾期率(%)'] = number_format((($arr[$i]['T+2逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+31逾期率(%)'] = number_format((($arr[$i]['T+31逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+3逾期率(%)'] = number_format((($arr[$i]['T+3逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+4逾期率(%)'] = number_format((($arr[$i]['T+4逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+5逾期率(%)'] = number_format((($arr[$i]['T+5逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+61逾期率(%)'] = number_format((($arr[$i]['T+61逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+6逾期率(%)'] = number_format((($arr[$i]['T+6逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+7逾期率(%)'] = number_format((($arr[$i]['T+7逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+91逾期率(%)'] = number_format((($arr[$i]['T+91逾期率(%)'])*100),2,'.','');
		$arr[$i]['当天还款率(%)'] = number_format((($arr[$i]['当天还款率(%)'])*100),2,'.','');
		$arr[$i]['提前还款率(%)'] = number_format((($arr[$i]['提前还款率(%)'])*100),2,'.','');
		$arr[$i]['放款笔数占比'] = number_format((($arr[$i]['放款笔数占比'])*100),2,'.','');
	}
}elseif($tmp == '逾期分析-金额-回溯版(存管)'){
	$Xlsname = "逾期分析-金额-回溯版(存管)".$time;
	$sqlName = " id,loan_name as '贷款名称',field as '类别',field_value as '具体类别',`T+1overdue_ratio` as 'T+1逾期率(%)',`T+2overdue_ratio` as 'T+2逾期率(%)',`T+31overdue_ratio` as 'T+31逾期率(%)',`T+3overdue_ratio` as 'T+3逾期率(%)',`T+4overdue_ratio` as 'T+4逾期率(%)',`T+5overdue_ratio` as 'T+5逾期率(%)',`T+61overdue_ratio` as 'T+61逾期率(%)',`T+6overdue_ratio` as 'T+6逾期率(%)',`T+7overdue_ratio` as 'T+7逾期率(%)',`T+91overdue_ratio` as 'T+91逾期率(%)',should_money as '应还金额(万元)',onday_ratio as '当天还款率(%)',prepay_ratio as '提前还款率(%)',repay_money as '放款金额 (万元)',repay_money_proportion as '放款金额占比',update_time as '数据更新时间'";
	$query = "select".$sqlName."from overdue_analysis_track_plus_money_cg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	if($field =='还款压力'&&$loan_name=='总计'){
		$c = $arr[2];
		$arr[2] = $arr[3];
		$arr[3] = $arr[4];
		$arr[4] = $arr[5];
		$arr[5] = $c;	
	}
	for($i=0;$i<count($arr);$i++){	
		$arr[$i]['T+1逾期率(%)'] = number_format((($arr[$i]['T+1逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+2逾期率(%)'] = number_format((($arr[$i]['T+2逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+31逾期率(%)'] = number_format((($arr[$i]['T+31逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+3逾期率(%)'] = number_format((($arr[$i]['T+3逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+4逾期率(%)'] = number_format((($arr[$i]['T+4逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+5逾期率(%)'] = number_format((($arr[$i]['T+5逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+61逾期率(%)'] = number_format((($arr[$i]['T+61逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+6逾期率(%)'] = number_format((($arr[$i]['T+6逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+7逾期率(%)'] = number_format((($arr[$i]['T+7逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+91逾期率(%)'] = number_format((($arr[$i]['T+91逾期率(%)'])*100),2,'.','');
		$arr[$i]['应还金额(万元)'] = number_format((($arr[$i]['应还金额(万元)'])/10000),2,'.','');
		$arr[$i]['当天还款率(%)'] = number_format((($arr[$i]['当天还款率(%)'])*100),2,'.','');
		$arr[$i]['提前还款率(%)'] = number_format((($arr[$i]['提前还款率(%)'])*100),2,'.','');
		$arr[$i]['放款金额 (万元)'] = number_format((($arr[$i]['放款金额 (万元)'])/10000),2,'.','');
		$arr[$i]['放款金额占比'] = number_format((($arr[$i]['放款金额占比'])/10000),2,'.','');
	}
}elseif($tmp == '逾期分析-金额-回溯版'){
	$Xlsname = "逾期分析-金额-回溯版".$time;
	$sqlName = " id,loan_name as '贷款名称',field as '类别',field_value as '具体类别',`T+1overdue_ratio` as 'T+1逾期率(%)',`T+2overdue_ratio` as 'T+2逾期率(%)',`T+31overdue_ratio` as 'T+31逾期率(%)',`T+3overdue_ratio` as 'T+3逾期率(%)',`T+4overdue_ratio` as 'T+4逾期率(%)',`T+5overdue_ratio` as 'T+5逾期率(%)',`T+61overdue_ratio` as 'T+61逾期率(%)',`T+6overdue_ratio` as 'T+6逾期率(%)',`T+7overdue_ratio` as 'T+7逾期率(%)',`T+91overdue_ratio` as 'T+91逾期率(%)',should_money as '应还金额(万元)',onday_ratio as '当天还款率(%)',prepay_ratio as '提前还款率(%)',repay_money as '放款金额 (万元)',repay_money_proportion as '放款金额占比',update_time as '数据更新时间'";
	$query = "select".$sqlName."from overdue_analysis_track_plus_money_tg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	if($field =='还款压力'&&$loan_name=='总计'){
		$c = $arr[2];
		$arr[2] = $arr[3];
		$arr[3] = $arr[4];
		$arr[4] = $arr[5];
		$arr[5] = $c;	
	}
	for($i=0;$i<count($arr);$i++){	
		$arr[$i]['T+1逾期率(%)'] = number_format((($arr[$i]['T+1逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+2逾期率(%)'] = number_format((($arr[$i]['T+2逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+31逾期率(%)'] = number_format((($arr[$i]['T+31逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+3逾期率(%)'] = number_format((($arr[$i]['T+3逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+4逾期率(%)'] = number_format((($arr[$i]['T+4逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+5逾期率(%)'] = number_format((($arr[$i]['T+5逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+61逾期率(%)'] = number_format((($arr[$i]['T+61逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+6逾期率(%)'] = number_format((($arr[$i]['T+6逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+7逾期率(%)'] = number_format((($arr[$i]['T+7逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+91逾期率(%)'] = number_format((($arr[$i]['T+91逾期率(%)'])*100),2,'.','');
		$arr[$i]['应还金额(万元)'] = number_format((($arr[$i]['应还金额(万元)'])/10000),2,'.','');
		$arr[$i]['当天还款率(%)'] = number_format((($arr[$i]['当天还款率(%)'])*100),2,'.','');
		$arr[$i]['提前还款率(%)'] = number_format((($arr[$i]['提前还款率(%)'])*100),2,'.','');
		$arr[$i]['放款金额 (万元)'] = number_format((($arr[$i]['放款金额 (万元)'])/10000),2,'.','');
		$arr[$i]['放款金额占比'] = number_format((($arr[$i]['放款金额占比'])/10000),2,'.','');
	}
}elseif($tmp == "逾期分析-笔数-回溯版"){
	$Xlsname = "逾期分析-笔数-回溯版".$time;
	$sqlName = " id,loan_name as '贷款名称',field as '类别',field_value as '具体类别',`T+1overdue_ratio` as 'T+1逾期率(%)',`T+2overdue_ratio` as 'T+2逾期率(%)',`T+31overdue_ratio` as 'T+31逾期率(%)',`T+3overdue_ratio` as 'T+3逾期率(%)',`T+4overdue_ratio` as 'T+4逾期率(%)',`T+5overdue_ratio` as 'T+5逾期率(%)',`T+61overdue_ratio` as 'T+61逾期率(%)',`T+6overdue_ratio` as 'T+6逾期率(%)',`T+7overdue_ratio` as 'T+7逾期率(%)',`T+91overdue_ratio` as 'T+91逾期率(%)',should_num as '应还笔数(笔)',onday_ratio as '当天还款率(%)',prepay_ratio as '提前还款率(%)',repay_num as '放款笔数 (笔)',repay_num_proportion as '放款笔数占比',update_time as '数据更新时间'";
	$query = "select".$sqlName."from overdue_analysis_track_plus_num_tg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	if($field =='还款压力'&&$loan_name=='总计'){
		$c = $arr[2];
		$arr[2] = $arr[3];
		$arr[3] = $arr[4];
		$arr[4] = $arr[5];
		$arr[5] = $c;	
	}
	for($i=0;$i<count($arr);$i++){	
		$arr[$i]['T+1逾期率(%)'] = number_format((($arr[$i]['T+1逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+2逾期率(%)'] = number_format((($arr[$i]['T+2逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+31逾期率(%)'] = number_format((($arr[$i]['T+31逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+3逾期率(%)'] = number_format((($arr[$i]['T+3逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+4逾期率(%)'] = number_format((($arr[$i]['T+4逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+5逾期率(%)'] = number_format((($arr[$i]['T+5逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+61逾期率(%)'] = number_format((($arr[$i]['T+61逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+6逾期率(%)'] = number_format((($arr[$i]['T+6逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+7逾期率(%)'] = number_format((($arr[$i]['T+7逾期率(%)'])*100),2,'.','');
		$arr[$i]['T+91逾期率(%)'] = number_format((($arr[$i]['T+91逾期率(%)'])*100),2,'.','');
		$arr[$i]['当天还款率(%)'] = number_format((($arr[$i]['当天还款率(%)'])*100),2,'.','');
		$arr[$i]['提前还款率(%)'] = number_format((($arr[$i]['提前还款率(%)'])*100),2,'.','');
		$arr[$i]['放款笔数占比'] = number_format((($arr[$i]['放款笔数占比'])*100),2,'.','');
	}
}elseif($tmp == "逾期分析-笔数-现状版"){
	$Xlsname = "逾期分析-笔数-现状版".$time;
	$sqlName = " id,loan_name as '借款类型',field as '类别',field_value as '具体类别',borrow_count as '放款本金(万元)',loaning_count as '在贷本金(万元)',should_count as '总应收本金(万元)',overdue_count as '总应收未收本金(万元)',Totaloverdue_ratio as '总逾期率(%)',M1count as 'M1本金(万元)',M1overdue_ratio as 'M1逾期率(%)',M2count as 'M2本金(万元)',M2overdue_ratio as 'M2逾期率(%)',M3count as 'M3本金(万元)',M3overdue_ratio as 'M3逾期率(%)',Morethan_M4count as '坏账本金(万元)',Morethan_M4overdue_ratio as '坏账率 (%)',repay_num_proportion as '放款笔数占比',update_time as '数据更新时间'";
	$query = "select".$sqlName."from overdue_analysis_current_plus_num_tg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	for($i=0;$i<count($arr);$i++){
		$arr[$i]['总逾期率(%)'] = number_format((($arr[$i]['总逾期率(%)'])*100),2,'.','');
		$arr[$i]['M1逾期率(%)'] = number_format((($arr[$i]['M1逾期率(%)'])*100),2,'.','');
		$arr[$i]['M2逾期率(%)'] = number_format((($arr[$i]['M2逾期率(%)'])*100),2,'.','');
		$arr[$i]['M3逾期率(%)'] = number_format((($arr[$i]['M3逾期率(%)'])*100),2,'.','');
		$arr[$i]['坏账率 (%)'] = number_format((($arr[$i]['坏账率 (%)'])*100),2,'.','');
		$arr[$i]['放款笔数占比'] = number_format((($arr[$i]['放款笔数占比'])*100),2,'.','');
	}
}elseif($tmp == "逾期分析-金额-现状版"){
	$Xlsname = "逾期分析-金额-现状版".$time;
	$sqlName = " id,loan_name as '借款类型',field as '类别',field_value as '具体类别',borrow_selfmoney as '放款本金(万元)',loaning_selfmoney as '在贷本金(万元)',should_selfmoney as '总应收本金(万元)',overdue_selfmoney as '总应收未收本金(万元)',Totaloverdue_ratio as '总逾期率(%)',M1selfmoney as 'M1本金(万元)',M1overdue_ratio as 'M1逾期率(%)',M2selfmoney as 'M2本金(万元)',M2overdue_ratio as 'M2逾期率(%)',M3selfmoney as 'M3本金(万元)',M3overdue_ratio as 'M3逾期率(%)',Morethan_M4selfmoney as '坏账本金(万元)',Morethan_M4overdue_ratio as '坏账率 (%)',放款金额占比,update_time as '数据更新时间'";
	$query = "select".$sqlName."from overdue_analysis_current_plus_money_tg where field = \"$field\" and loan_name= \"$loan_name\" and update_time = \"$time\"";
	$result = mysqli_query($link, $query);
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	mysqli_close($link);
	if($field =='还款压力'&&$loan_name=='总计'){
		$c = $arr[2];
		$arr[2] = $arr[3];
		$arr[3] = $arr[4];
		$arr[4] = $arr[5];
		$arr[5] = $c;
	}
	for($i=0;$i<count($arr);$i++){
		$arr[$i]['放款本金(万元)'] = number_format((($arr[$i]['放款本金(万元)'])/10000),2,'.','');
		$arr[$i]['在贷本金(万元)'] = number_format((($arr[$i]['在贷本金(万元)'])/10000),2,'.','');
		$arr[$i]['总应收本金(万元)'] = number_format((($arr[$i]['总应收本金(万元)'])/10000),2,'.','');
		$arr[$i]['总应收未收本金(万元)'] = number_format((($arr[$i]['总应收未收本金(万元)'])/10000),2,'.','');
		$arr[$i]['总逾期率(%)'] = number_format((($arr[$i]['总逾期率(%)'])*100),2,'.','');
		$arr[$i]['M1本金(万元)'] = number_format((($arr[$i]['M1本金(万元)'])/10000),2,'.','');
		$arr[$i]['M1逾期率(%)'] = number_format((($arr[$i]['M1逾期率(%)'])*100),2,'.','');
		$arr[$i]['M2本金(万元)'] = number_format((($arr[$i]['M2本金(万元)'])/10000),2,'.','');
		$arr[$i]['M2逾期率(%)'] = number_format((($arr[$i]['M2逾期率(%)'])*100),2,'.','');
		$arr[$i]['M3本金(万元)'] = number_format((($arr[$i]['M3本金(万元)'])/10000),2,'.','');
		$arr[$i]['M3逾期率(%)'] = number_format((($arr[$i]['M3逾期率(%)'])*100),2,'.','');
		$arr[$i]['坏账本金(万元)'] = number_format((($arr[$i]['坏账本金(万元)'])/10000),2,'.','');
		$arr[$i]['坏账率 (%)'] = number_format((($arr[$i]['坏账率 (%)'])*100),2,'.','');
		$arr[$i]['放款金额占比'] = number_format((($arr[$i]['放款金额占比'])*100),2,'.','');
		
	}
}
	
	
foreach($arr as $v){
	$brr = $v;
}
$key = array_keys($brr);

exportExcel($arr,$Xlsname,$key,$tmp);
