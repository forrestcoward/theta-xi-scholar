<?php
	include 'isbn_conversions.php';
	include '../data.php';
	
	$referer = $_SERVER['HTTP_REFERER'];
	if($referer == $data["book_search_url_full"]) {
	
		// Parameters to this file include an isbn number and a url which will include the isbn as a parameter. 
		
		$isbn_num = $_GET["isbn"];
		

		$isbn10 = ISBN13toISBN10($isbn_num);
		$isbn13 = ISBN10toISBN13($isbn_num);
		
		$remote_url = $_GET["remote_url"];
		$full_url=$remote_url . $isbn10;
		$xml = file_get_contents($full_url);
		echo $xml;
	}
?>