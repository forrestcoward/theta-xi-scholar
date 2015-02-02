<?php

	// Given a did (department id), echos a list of unique course number separated by a '-' such that a course number listed means there is a test with that course number and that did. This is used to dynamically population the 'Class Number' box after a department has been selected on the Test Search page. 
	
	include '../data.php';
	include '../common.php';
	
	if(isset($_GET['did'])) {
		$did = $_GET['did'];
		$sql = 'SELECT distinct cnum
				FROM documents
				WHERE did = '.$did;
		$result = mysql_query($sql);
		while($array = mysql_fetch_array($result)) {
			echo $array[0];
			echo '-';
		}
	}
		
?>