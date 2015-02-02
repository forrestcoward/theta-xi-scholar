<?php

include '../data.php';
include '../common.php';

$referer = $_SERVER['HTTP_REFERER'];
if($referer == $data["book_search_url_full"]) {
	$id = $_POST["id"];
	$isbn13 = $_POST["isbn13"];

	$sql = 'SELECT * FROM owns WHERE uid='.$id.' and isbn13="'.$isbn13.'" and owns=true';
	$result = mysql_query($sql);
	if(mysql_num_rows($result) == 0) {
		$sql = 'INSERT INTO owns (isbn13, uid, owns) VALUES("'.$isbn13.'",'.$id.', true)';
		$result = mysql_query($sql);
		echo "1";
	} else {
		echo "2";
	} 
	// Echo 1 for success, 2 for failure.
}
?>