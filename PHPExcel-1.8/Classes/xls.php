<?php
/** 
 * ����(����)Excel���ݱ�� 
 * @param  array   $list        Ҫ�����������ʽ������ 
 * @param  string  $filename    ������Excel������ݱ���ļ��� 
 * @param  array   $indexKey    $list��������Excel����ͷ$header��ÿ����Ŀ��Ӧ���ֶε�����(keyֵ) 
 * @param  array   $startRow    ��һ��������Excel�������ʼ�� 
 * @param  [bool]  $excel2007   �Ƿ�����Excel2007(.xlsx)���ϼ��ݵ����ݱ� 
 * ����: $indexKey��$list�����Ӧ��ϵ����: 
 *     $indexKey = array('id','username','sex','age'); 
 *     $list = array(array('id'=>1,'username'=>'YQJ','sex'=>'��','age'=>24)); 
 */  
function exportExcel($list,$filename,$indexKey,$startRow=1,$excel2007=false){  
    //�ļ�����  
    require_once 'PHPExcel.php';  
    require_once 'PHPExcel/Writer/Excel2007.php';  
      
    if(empty($filename)) $filename = time();  
    if( !is_array($indexKey)) return false;  
      
    $header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');  
    //$header_arr = $indexKey;
    //��ʼ��PHPExcel()  
    $objPHPExcel = new PHPExcel();  
      
    //���ñ���汾��ʽ  
    if($excel2007){  
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);  
        $filename = $filename.'.xlsx';  
    }else{  
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);  
        $filename = $filename.'.xls';  
    }  
      
    //����������д���ݵ��������ȥ  
    $objActSheet = $objPHPExcel->getActiveSheet();  
    //$startRow = 1;  
    foreach ($list as $row) {  
        foreach ($indexKey as $key => $value){  
            //���������õ�Ԫ�������  
            $objActSheet->setCellValue($header_arr[$key].$startRow,$row[$value]);  
        }  
        $startRow++;  
    }  
      
    // ��������������������  
    header("Pragma: public");  
    header("Expires: 0");  
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");  
    header("Content-Type:application/force-download");  
    header("Content-Type:application/vnd.ms-execl");  
    header("Content-Type:application/octet-stream");  
    header("Content-Type:application/download");;  
    header('Content-Disposition:attachment;filename='.$filename.'');  
    header("Content-Transfer-Encoding:binary");  
    $objWriter->save('php://output');  
} 