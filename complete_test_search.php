<?php

	// 	$isbn, $title, $author, $restriction, $isbnSet, $authorSet, $titleSet, $restrictionSet all defined in library.php
	$department = strip_tags(clean($department));
	$courseNum = strip_tags(clean($courseNum));
	
	$department = trim($department);
	$courseNum = trim($courseNum);
	
	if(!$departmentSet && !$courseNumSet) {
		echo "Please specify a search.";
	} else if(!is_numeric($courseNum) || !is_numeric($department)) {
		echo "Illegal parameters. Please try again.";
	} else {
		$sql = 'SELECT doc.url, doc.year, doc.cnum, doc.type, doc.term, doc.comments, dep.short, doc.difficulty, doc.completed
				FROM documents doc, departments dep
				WHERE doc.did = dep.did and doc.did = '.$department.' and doc.cnum = '.$courseNum.'
				ORDER BY doc.year desc';
					
		$result = mysql_query($sql);
		if($result) {
		$num_results = mysql_num_rows($result);		
		printSearchHeader($department, $courseNum, $num_results);
		
		$count = 0;
		while($array = mysql_fetch_array($result)) {
		
			echo '<div class="test_result">';
			echo '<br/>';
			?> 
			<img src="../txscholar/images/blue_arrow.png">
			<a href="http://www.uwthetaxi.com/txscholar/pdf_server.php?file=<?php echo $array[0]; ?>"><?php echo $array[6].' '.$array[2].' '.ucwords($array[3]).', '.ucwords($array[4]).' '.$array[1];?></a>
			<?php 
			echo '<br/>';
			$comments = "";
			if($array[5] != "") { $comments = $array[5]; }
			echo '<strong>Uploader Comment</strong>: '.$array[5].'<br />';
			echo '<strong>Difficulty</strong>: '.$array[7].'<br/>';
			echo '<strong>Completed</strong>: '.$array[8].'<br/>';
			$count++;
			echo '<br />';
			echo '</div>';
		}
		} else {
			echo "Search error.";
		}
	}
	
	// Responsible for printing the search header that indicates the parameters to the search. 
	function printSearchHeader($department, $courseNum, $num_results) {
		echo '<br/><strong>'.$num_results.' document(s) found!</strong><br/>';
		echo 'Parameters to search:<br/>';
		echo  'department->"'.$department.'"<br/>';
		echo  'course number->"'.$courseNum.'"<br/>';    
	}
	
?>
