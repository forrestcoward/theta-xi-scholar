<?php

// Set content type to xml. 
include '../common.php';
include '../data.php';
include 'isbn_conversions.php';

$referer = $_SERVER['HTTP_REFERER'];
//if($referer == $data["book_search_url_full"]) {

	header('Content-type: text/xml');
	$isbn = $_GET["isbn"];
	$isbn = trim($isbn);
	$isbn = clean($isbn);

	if(!checkIsbn($isbn)) {
		// Empty XML.
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo '<bookinfo>';
		echo 'Invalid ISBN!';
		echo '</bookinfo>';
	} else {
		$isbn13 = "";
		$isbn10 = "";

		if(strlen($isbn) == 10) {
			$isbn10 = $isbn;
			$isbn13 = ISBN10toISBN13($isbn10);
		}
		if(strlen($isbn) == 13) {
			$isbn10 = ISBN13toISBN10($isbn);
			$isbn13 = $isbn;
		}

		$sql = 'SELECT * FROM books WHERE isbn10 = "'.$isbn10.'"';
		$result = mysql_query($sql);

		if($result) {
			// Output XML Results.
			if(mysql_num_rows($result) == 1) {
				echo '<?xml version="1.0" encoding="UTF-8"?>';
				echo '<bookinfo>';
				while($array = mysql_fetch_array($result)) {

					for($i = 2; $i <= 7; $i++) {
						// Fix unparsable XML characters.
						$array[$i] = htmlspecialchars($array[$i], ENT_QUOTES);
					}
					echo '<book isbn13="'.$array[0].'" isbn10="'.$array[1].'">';
					echo '<title>'.$array[2].'</title>';
					echo '<pub_date>'.$array[3].'</pub_date>';
					echo '<author>'.$array[4].'</author>';
					echo '<publisher_info>'.$array[5].'</publisher_info>';
					echo '<image_url>'.$array[6].'</image_url>';
					echo '<edition>'.$array[7].'</edition>';
					echo '<pages>'.$array[8].'</pages>';
					echo '</book>';
				}
				echo '</bookinfo>';
			} else {
				echo '<?xml version="1.0" encoding="UTF-8"?>';
				echo '<bookinfo>';
				echo '</bookinfo>';
			}
		}
	}
//}  else {
		//echo "You came from ".$referer.'.';
		//echo "You were supposed to come from ".$data["book_search_url_full"];
//}
?>