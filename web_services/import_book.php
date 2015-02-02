<?php

// Not just responsible for the book image, but the edition and pages as well. This is because
// those three pieces of information come from the same website.

include '../data.php';
include '../common.php';
include 'isbn_conversions.php';

$referer = $_SERVER['HTTP_REFERER'];
if($referer == $data["book_search_url_full"]) {
	$isbn = $_POST["isbn"];
	$image_url = $_POST["image_url"];
	$edition = $_POST["edition"];
	$pages = $_POST["pages"];
	$author = $_POST["author"];
	$publisher = $_POST["publisher"];
	$title = $_POST["title"];
	$pubdate = $_POST["pubdate"];

	$isbn13 = "";
	$isbn10 = "";
	$isbn = trim($isbn);

	if(strlen($isbn) == 10) {
		$isbn10 = $isbn;
		$isbn13 = ISBN10toISBN13($isbn10);
	}

	if(strlen($isbn) == 13) {
		$isbn10 = ISBN13toISBN10($isbn);
		$isbn13 = $isbn;
	}

	if($pubdate == "N/A") { $pubdate = ""; }
	if($author == "N/A") { $author = ""; }
	if($image_url == "N/A") { $image_url = ""; }
	if($edition == "N/A") { $edition = ""; }
	if($pages == "N/A") { $pages = ""; }

	$direct_url = $_SERVER['DOCUMENT_ROOT']."/txscholar/book_images/".$isbn.".jpeg";
	$server_url = 'http://www.uwthetaxi.com/txscholar/book_images/'.$isbn.'.jpeg';
	// Copy image onto server.
	copy($image_url, $direct_url);

	$sql = 'INSERT INTO books VALUES("'.$isbn13.'","'.$isbn10.'","'.$title.'","'.$pubdate.'","'.$author.'","'.$publisher.'","'.$server_url.'","'.$edition.'","'.$pages.'")';

	// Insert book information into database.
	$result = mysql_query($sql);
}
?>




