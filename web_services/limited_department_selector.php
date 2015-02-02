<?php

	// Emits options tags for an html drop down menu where each option is the abbrevation for a department at UW.
	
	include '../common.php';

	$sql = "SELECT distinct dep.short, dep.full, dep.did 
			FROM departments dep, documents doc
			WHERE doc.did = dep.did";
	$result = mysql_query($sql);
	while($array = mysql_fetch_array($result)) {
		$tag = htmlspecialchars($array[0]);
		$description = htmlspecialchars($array[0].' ('.$array[1].')');
		echo '<option value="'.$array[2].'">'.$description.'</option>';
	}
?>
