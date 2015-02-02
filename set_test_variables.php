<?php
	$departmentSet = isset($_GET["department"]);
	$courseNumSet = isset($_GET["course_num"]);
	$department = "";
	$courseNum = "";
	if($departmentSet) {
		$department = $_GET["department"];
		$department = trim($department);
		$department = clean($department);
	}
	if($courseNumSet) {
		$courseNum = $_GET["course_num"];
		$courseNum = trim($courseNum);
		$courseNum = clean($courseNum);
	}
?>