<?php

	// 	$isbn, $title, $author, $restriction, $isbnSet, $authorSet, $titleSet, $restrictionSet all defined in library.php (setlibraryvariables.php)
	$isbn = strip_tags(clean($isbn));
	$title = strip_tags(clean($title));
	$author = strip_tags(clean($author));
	$display = strip_tags(clean($display));
	$orderby = strip_tags(clean($orderby));
	
	if(!$isbnSet && !$titleSet && !$authorSet) {
		echo "Please specify a search.";
	} else {
		// Search all books.
		if($restriction == 1) {
			if($orderby == "title" || $orderby == "author") {
				if($isbn != "") {
					$sql = 'SELECT * FROM books WHERE isbn10 = '.$isbn.' or isbn13 = '.$isbn.' order by '.$orderby;
				} else {
					$sql = 'SELECT * FROM books WHERE author like "%'.$author.'%" and title like "%'.$title.'%" order by '.$orderby;
				}
			} else {
				if($isbn != "") {
					$sql = 'SELECT * FROM books WHERE isbn10 = '.$isbn.' or isbn13 = '.$isbn;
				} else {
					$sql = 'SELECT * FROM books WHERE author like "%'.$author.'%" and title like "%'.$title.'%"';
				}
			}
		}
		// Search only books owned by a user.
		if($restriction == 2) {
			if($orderby == "title" || $orderby == "author") {
				if($isbn != "") {
					$sql = 	'SELECT b.isbn13, b.isbn10, b.title as title, b.pub_date, b.author as author, b.publisher, b.image, b.edition, b.pages 
							 FROM books b, owns o 
							 WHERE o.owns = true and o.isbn13 = b.isbn13 and b.isbn10 = "'.$isbn.'" or b.isbn13 = "'.$isbn.'" order by '.$orderby;
				} else {
					$sql = 	'SELECT b.isbn13, b.isbn10, b.title as title, b.pub_date, b.author as author, b.publisher, b.image, b.edition, b.pages 
							 FROM books b, owns o 
							 WHERE o.owns = true and o.isbn13 = b.isbn13 and author like "%'.$author.'%" and title like "%'.$title.'%" order by '.$orderby;
				}
			} else {
				if($isbn != "") {
					$sql = 	'SELECT b.isbn13, b.isbn10, b.title, b.pub_date, b.author, b.publisher, b.image, b.edition, b.pages 
							 FROM books b, owns o 
							 wWHERE o.owns = true and o.isbn13 = b.isbn13 and b.isbn10 = "'.$isbn.'" or b.isbn13 = "'.$isbn.'" group by b.isbn13 ';
				} else {
					$sql = 	'SELECT b.isbn13, b.isbn10, b.title, b.pub_date, b.author, b.publisher, b.image, b.edition, b.pages 
							 FROM books b, owns o 
							 WHERE o.owns = true and o.isbn13 = b.isbn13 and author like "%'.$author.'%" and title like "%'.$title.'%" group by b.isbn13 ';
				}
			}
		}
		// Search only books owned by the current user. 
		if($restriction == 3) {
			if($orderby == "title" || $orderby == "author") {
				if($isbn != "") {
					$sql = 	'SELECT b.isbn13, b.isbn10, b.title, b.pub_date, b.author, b.publisher, b.image, b.edition, b.pages 
							 FROM books b, owns o 
							 WHERE o.owns = true and o.uid ='.$id.' and o.isbn13 = b.isbn13 and b.isbn10 = "'.$isbn.'" or b.isbn13 = "'.$isbn.'" 
							 ORDER BY '.$orderby;
				} else {
					$sql = 	'SELECT b.isbn13, b.isbn10, b.title, b.pub_date, b.author, b.publisher, b.image, b.edition, b.pages 
							 FROM books b, owns o 
							 WHERE o.owns = true and o.uid ='.$id.' and o.isbn13 = b.isbn13 and author like "%'.$author.'%" and title like "%'.$title.'%" ORDER BY '.$orderby;
				}
			} else {
				if($isbn != "") {
					$sql = 	'SELECT b.isbn13, b.isbn10, b.title, b.pub_date, b.author, b.publisher, b.image, b.edition, b.pages 
							 FROM books b, owns o 
							 WHERE o.owns = true and o.uid ='.$id.' and o.isbn13 = b.isbn13 and b.isbn10 = "'.$isbn.'" or b.isbn13 = "'.$isbn.'" group by b.isbn13 ';
				} else {
					$sql = 	'SELECT b.isbn13, b.isbn10, b.title, b.pub_date, b.author, b.publisher, b.image, b.edition, b.pages 
							 FROM books b, owns o 
							 WHERE o.owns = true and o.uid ='.$id.' and o.isbn13 = b.isbn13 and author like "%'.$author.'%" and title like "%'.$title.'%" group by b.isbn13 ';
				}
			}
		}
			
		$desired_page_count = 55;
		
		$results_per_page = 150;
		if($display == "full") {
			$results_per_page = 50;
		} 
		$result = mysql_query($sql);
		$num_results = mysql_num_rows($result);
		$page = $_GET["page"];
		$num_pages = $num_results/$results_per_page + 1;
		$lower = $results_per_page*($page-1);
		$higher = $results_per_page*$page;
		$owns = array(); 
				
		printSearchHeader($restriction, $isbn, $title, $author, $page, $num_pages, $num_results, $display, $orderby);
		printPageLinks($restriction, $isbn, $title, $author, $page, $num_pages, $desired_page_count, $num_results, $display, $orderby);
		echo '<br/>';
		
		if($num_results <= $results_per_page) { // Less results than $results_per_page results, print them all out. 
			$count = 0;
			if($display == "condensed") {
				echo '<table class="condensed_book_table">'; 
				echo '<th>ISBN</th>';
				echo '<th>Title</th>';
				echo '<th>Author</th>';
				if($restriction == 2 || $restriction == 3) {
					echo '<th>Owned By</th>';
				}
			}
			while($array = mysql_fetch_array($result)) {
				if($restriction == 1) {
					if($display == "full") {
						echo generateBookTable($array, $count+1);
					} else {
						echo generateCondensedBookTable($array, $count+1);
					}
				}
				if($restriction == 2 || $restriction == 3) {
					$the_isbn = $array[0];
					$sql = 'SELECT u.username
							FROM owns o, user u 
							WHERE o.isbn13 = "'.$the_isbn.'" and o.uid = u.ID';
					$names = mysql_query($sql);
					$index = 0;
					$owns = array();
					while($names_array = mysql_fetch_array($names)) {
						$owns[$index] = $names_array[0];
						$index++;
					}
					if($display == "full") {
						echo generateBookTableWithOwners($array, $count+1, $owns);
					} else {
						echo generateCondensedBookTableWithOwners($array, $count+1, $owns);
					}
				}
				$count++;
			}
			if($display == "condensed") { echo "</table>"; }
			
		} else {
		
			$count = 0;
			if($display == "condensed") {
				echo '<table class="condensed_book_table">'; 
				echo '<th>ISBN</th>';
				echo '<th>Title</th>';
				echo '<th>Author</th>';
			}
			
			while($count < $higher && $count < $num_results) {
				$array = mysql_fetch_row($result);
				if($count >= $lower && $count < $higher) {
					if($restriction == 1) {
						if($display == "full") {
							echo generateBookTable($array, $count+1);
						} else {
							echo generateCondensedBookTable($array, $count);
						}
					}
					if($restriction == 2 || $restriction == 3) {
						$the_isbn = $array[0];
						$sql = 'SELECT u.username
						        FROM owns o, user u 
								WHERE o.isbn13 = "'.$the_isbn.' and o.uid = u.ID';
						$names = mysql_query($sql);
						$owns = array();
						while($names_array = mysql_fetch_array($names)) {
							$owns[$index] = $names_array[0];
							$index++;
						}
						if($display == "full") {
							echo generateBookTableWithOwners($array, $count+1, $owns);
						} else {
							echo generateCondensedBookTableWithOwners($array, $count+1, $owns);
						}
					}
				}
				$count++;
			}
			if($display == "condensed") { echo "</table>"; }
		}
		
		echo '<br/>';
		if($num_results > 4) {
			printPageLinks($restriction, $isbn, $title, $author, $page, $num_pages, $desired_page_count, $num_results, $display, $orderby);
		}
	}
	
	// Responsible for printing the search header that indicates the parameters to the search. 
	function printSearchHeader($restriction, $isbn, $title, $author, $page, $num_pages, $num_results, $display, $orderby) {
		echo '<br/><strong>'.$num_results.' book(s) found!</strong><br/>';
		
		
		echo 'Parameters to search:<br/>';
		echo  'isbn->"'.$isbn.'"<br/>';
		echo  'title->"'.$title.'"<br/>';    
		echo  'author->"'.$author.'"<br/>';
		//echo  'restriction->"'.$restriction.'"<br/>';
		echo  'display->"'.$display.'"<br/>';
		echo  'ordered by->"'.$orderby.'"<br/><br/>';
		
	}
	
	// Responsible for printing page links so the user can see more results. Everything printed is contained in a div with class 'page_selection'. The link to the current page is given class 'current_page', and all other links are given class 'current page'.
	function printPageLinks($restriction, $isbn, $title, $author, $page, $num_pages, $desired_page_count, $num_results, $display, $orderby) {
	
		if($num_results != 0) {	
			echo "<div class='page_selection'>";
			echo "Pages: ";
			
			if($num_pages <= $desired_page_count) {
				for($i = 1; $i < $num_pages; $i++) {
					$params = htmlspecialchars('restriction='.$restriction.'&page='.$i.'&isbn='.$isbn.'&title='.$title.'&author='.$author.'&display='.$display.'&orderby='.$orderby);
					if($i != $page) {
						echo '<a class="page_link" href="library.php?'.$params.'">'.$i.'  </a>';
					} else {
						echo '<a class="current_page" href="library.php?'.$params.'">'.$i.'  </a>';
					}
				}	
			} else {
			
				// Calculate left hand side link limit.
				$count = 0;
				$marker = $page;
				while($count < $desired_page_count/2 && $marker > 1) {
					$count++;
					$marker--;
				}
				$left = $marker;
				
				// Calculate right hand side link limit.
				$count = 0;
				$marker = $page;
				while($count < $desired_page_count/2 && $marker < $num_pages) {
					$count++;
					$marker++;
				}
				$right = $marker;
				
				for($i = $left; $i < $right; $i++) {
					$params = htmlspecialchars('restriction='.$restriction.'&page='.$i.'&isbn='.$isbn.'&title='.$title.'&author='.$author.'&display='.$display.'&orderby='.$orderby);
					if($i != $page) {
						echo '<a class="page_link" href="library.php?'.$params.'">'.$i.'  </a>';
					} else {
						echo '<a class="current_page" href="library.php?'.$params.'">'.$i.'  </a>';
					}
				}
			}
			echo "</div>";
		}
	}
?>
