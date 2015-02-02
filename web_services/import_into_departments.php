<?php 

// Insert majors.csv into departments database table. Department database table has schema (did, short, full), where did is the primary key. 

include '../data.php';
include '../common.php';

$already_uploaded = true;

if(!$already_uploaded) {
	foreach(file("../text_data/majors.csv") as $data) {
		$tokens = explode(",", $data);
		$full = $tokens[0];
		$short = $tokens[1];
		$sql = "INSERT INTO departments (short, full) VALUES('$short','$full')";
		$result = mysql_query($sql);
	}
}

?>