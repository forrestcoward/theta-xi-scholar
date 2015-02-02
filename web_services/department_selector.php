<?php

	// Emits options tags for an html drop down menu where each option is the abbrevation for a department at UW.
	include '../data.php';
	include '../common.php';
	
	$sql = "SELECT short, full, did FROM departments order by short asc";
	$result = mysql_query($sql);
	while($array = mysql_fetch_array($result)) {
		$tag = htmlspecialchars($array[0]);
		$description = htmlspecialchars($array[0].' ('.$array[1].')');
		echo '<option value="'.$array[2].'">'.$description.'</option>';
	}
?>
