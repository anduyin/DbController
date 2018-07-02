<?php
function exportExcel($list,$filename,$indexKey=array(),$tmp){
	require_once 'PHPExcel/IOFactory.php';
	require_once 'PHPExcel.php';
	require_once 'PHPExcel/Writer/Excel2007.php';
	$header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$objPHPExcel = new PHPExcel();                        //初始化PHPExcel(),不使用模板
	//$template = dirname(__FILE__).'/'.$tmp;          //使用模板
	//$objPHPExcel = PHPExcel_IOFactory::load($template);     //加载excel文件,设置模板
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);  //设置保存版本格式
	//接下来就是写数据到表格里面去
	$objActSheet = $objPHPExcel->getActiveSheet();
	//$objActSheet->setCellValue('A2',  "测试");
	//$objActSheet->setCellValue('C2',  "导出时间：".date('Y-m-d H:i:s'));
	$i = 2;
	$titleRow = 1;  
    foreach($indexKey as $key => $value){
    	$objActSheet->setCellValue($header_arr[$key].$titleRow,$value);
    }
	foreach ($list as $row) {
		foreach ($indexKey as $key => $value){
			//这里是设置单元格的内容
			$objActSheet->setCellValue($header_arr[$key].$i,$row[$value]);
		}
		$i++;
	}
	// 1.保存至本地Excel表格
	//$objWriter->save($filename.'.xlsx');
	// 2.接下来当然是下载这个表格了，在浏览器输出就好了
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");;
	header('Content-Disposition:attachment;filename="'.$filename.'.xlsx"');
	header("Content-Transfer-Encoding:binary");
	$objWriter->save('php://output');
}