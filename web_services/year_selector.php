<?php

	// Emits options tags for an html drop down menu where each option is a year starting at the current year. 

	include '../common.php';

	$sql = 'SELECT year(CURRENT_TIMESTAMP)';
	$result = mysql_query($sql);
	while($array = mysql_fetch_array($result)) {
		$current_year = $array[0];
	}
	echo '<option value="'.$current_year.'">'.$current_year.'</option>';
	
	$num_year_displayed = 50;
	while($num_year_displayed > 0) {
		$current_year--;
		echo '<option value="'.$current_year.'">'.$current_year.'</option>';
		$num_year_displayed--;
	}
?>
