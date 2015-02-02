<?php

	// Search only books owned by the current user. 
	$sql = 	'SELECT b.isbn13, b.isbn10, b.title, b.pub_date, b.author, b.publisher, b.image, b.edition, b.pages 
			 FROM books b, owns o 
			 WHERE o.owns = true and o.uid ='.$id.' and o.isbn13 = b.isbn13 
			 GROUP BY b.isbn13
			 ORDER BY b.title';
			
	$count = 0;
	$result = mysql_query($sql);
	echo '<table class="condensed_user_book_table">'; 
	echo '<th>ISBN</th><th>Title</th><th>Author</th><th>X</th>';
	while($array = mysql_fetch_array($result)) {
		echo generateCondensedBookTable($array, $count, true);
		$count++;
	}
	echo "</table>";
?>
