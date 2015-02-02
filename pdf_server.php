<?php

if (isset($_GET['file'])) {
	include 'data.php';
	include 'common.php';
	$file = $_GET['file'];
	$file = $data["upload_path"].$file.'.pdf';
	if (file_exists($file) && is_readable($file)) {
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=download.pdf"); 
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Description: File Transfer");            
		header("Content-Length: " . filesize($file));
		flush(); // this doesn't really matter.
		$fp = fopen($file, "r");
		while (!feof($fp)) {
    		echo fread($fp, 65536);
   			flush(); // this is essential for large downloads
		} 
		fclose($fp);
	} else {
		header("HTTP/1.0 404 Not Found");
		echo $file;
		echo '<br/><br/><br/>';
		echo '<h1>Error 404: File Not Found: <br/>'.$file.'</h1>';
	}
}
?>