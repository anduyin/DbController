<?php 
$dir = $_GET['dir'];
$filename = $_GET['filename'];
$dirinfo = $dir.'/'.$filename;
$file=fopen($dirinfo,"r");
header("Content-Type: application/octet-stream");
header('Content-Type: application/zip');
header("Accept-Ranges: bytes");
header("Content-Disposition: attachment; filename=$filename");
header('Content-Transfer-Encoding: binary');
readfile($dirinfo);
?>