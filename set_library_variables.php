<?php
	$isbnSet = isset($_GET["isbn"]);
	$titleSet = isset($_GET["title"]);
	$authorSet = isset($_GET["author"]);
	$restrictionSet = isset($_GET["restriction"]);
	$displaySet = isset($_GET["display"]);
	$orderbySet = isset($_GET["orderby"]);
	$restriction = 1;
	$display = 'full';
	$orderby = 'none';
	$isbn = "";
	$title = "";
	$author = "";
	
	if($isbnSet) {
		$isbn = $_GET["isbn"];
		$isbn = trim($isbn);
		$isbn = clean($isbn);
	}
	if($titleSet) {
		$title = $_GET["title"];
		$title = trim($title);
		$title = clean($title);
	}
	if($authorSet) {
		$author = $_GET["author"];
		$author = trim($author);
		$author = clean($author);
	}
	if($restrictionSet) {
		$restriction = $_GET["restriction"];
	}
	
	if($displaySet) {
		$display = $_GET["display"];
	}
	
	if($orderbySet) {
		$orderby = $_GET["orderby"];
	}
?>