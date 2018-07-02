<?php
/**
 * 提供DailyRepay的xls的下载,这里用的是head的方式
 */
include "./DailyRepay.php";
$start = isset($_POST['start']) ? $_POST['start']: "";
$end = isset($_POST['end']) ? $_POST['end']: "";
DailyRepay::downloadXls($start, $end);
