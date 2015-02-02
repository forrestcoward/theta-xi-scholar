<?php

	include 'data.php';
	include 'common.php';
	
    // Configuration
	$debug = false;
    $allowed_filetypes = array('.pdf'); 
    $max_filesize = 10000000; // Maximum filesize in bytes.
	$upload_path = $data["upload_path"];
	
	// Some input forms will be empty. In such a case we want to ignore those for the rest of the checks. 
 	$empty = array();
	$numfiles = count($_FILES);
	$index = 0;
	for($fnum = 0; $fnum < $numfiles; $fnum++) {
		$form_name = 'userfile'.($fnum+1);
		$file_name = $_FILES[$form_name]['name'];
		if($file_name == "") {
			$empty[$index] = $fnum;
			$index++;
		}
	}
	
	// Some debug information to examine uploaded files. 
	if($debug) {
		for($fnum = 0; $fnum < $numfiles; $fnum++) {
			if(!in_array($fnum, $empty)) {
				$form_name = 'userfile'.($fnum+1);
				echo '<br/>';
				echo 'error: '.$_FILES[$form_name]['error'].'<br/>';
				echo 'mime: '.$_FILES[$form_name]['type'].'<br/>';
				echo 'size: '.$_FILES[$form_name]['size'].'<br/>';
				echo 'name: '.$_FILES[$form_name]['name'].'<br/>';
				echo 'temp: '.$_FILES[$form_name]['tmp_name'].'<br/>';
			}		
		}
		echo '<br/>';
	}
	
	// Check mime type of each file.
	for($fnum = 0; $fnum < $numfiles; $fnum++) {
		if(!in_array($fnum, $empty)) {
			$form_name = 'userfile'.($fnum+1);
		    if('application/pdf' != $_FILES[$form_name]['type']) {
				echo $_FILES[$form_name]['name'].' has an illegal file type.<br/>';
				echo 'Illegal file type was: '.$_FILES[$form_name]['type'].'.<br/>';
	    		echo 'Please upload a valid file type!';
	    		exit(0);
			}	
		}		
	}
	
	// Check extension of each file.
	for($fnum = 0; $fnum < $numfiles; $fnum++) {
		if(!in_array($fnum, $empty)) {
			$form_name = 'userfile'.($fnum+1);
			$filename = $_FILES[$form_name]['name'];
			$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
			if(!in_array($ext,$allowed_filetypes)) {
				echo $_FILES[$form_name]['name'].' has an illegal extension. Please upload the correct file type.';
				echo 'Illegal extension was: '.$ext.'<br/>';
				exit(0);
   			}
		}		
	}
	
	// Check size of each file.
	for($fnum = 0; $fnum < $numfiles; $fnum++) {
		if(!in_array($fnum, $empty)) {
			$form_name = 'userfile'.($fnum+1);
			if(filesize($_FILES[$form_name]['tmp_name']) > $max_filesize) {
				echo 'One of your file was too large. Please upload a smaller file.<br/>';
				echo 'Size of .'.$_FILES[$form_name]['name'].' was '.$_FILES[$form_name]['tmp_name'].'<br/>';
				echo 'The maximum file size is '.$max_filesize;
				exit(0);
   			}
		}		
	}
	
	// Make sure the upload path is writeable. 
	if(!is_writable($upload_path)) {
		echo 'Trying to write to '.$upload_path.'.';
		echo 'You cannot upload to the specified Directory.';
		exit(0);
    }
	
	// Retrieve form data. 
	$course = ""; $course_num = ""; $year = ""; $doctype = ""; $term = ""; $comments = ""; $id = "";
	if(isset($_POST['course'])) { $course = $_POST['course']; } else { exit(0); }
	if(isset($_POST['course_num'])) { $course_num = $_POST['course_num']; } else { exit(0); }
	if(isset($_POST['year'])) { $year = $_POST['year']; } else { exit(0); }
	if(isset($_POST['doctype'])) { $doctype = $_POST['doctype']; } else { exit(0); }
	if(isset($_POST['term'])) { $term = $_POST['term']; } else { exit(0); }
	if(isset($_POST['comments'])) { $comments = $_POST['comments']; } else { exit(0); }
	if(isset($_POST['difficulty'])) { $difficulty = $_POST['difficulty']; } else { exit(0); }
	if(isset($_POST['completed'])) { $completed = $_POST['completed']; } else { exit(0); }
	if(isset($_POST['id'])) { $id = $_POST['id']; } else { exit(0); }
	
	// Clean form data.
	//$doctype = clean($doctype);
	//$comments = clean($comments);
	$comments = strip_html_tags($comments);
	$course_num = strip_html_tags($course_num);
	
	// Print debug information for form data. 
	if($debug) {
		echo '<br/>';
		echo $course.'<br/>';
		echo $course_num.'<br/>';
		echo $year.'<br/>';
		echo $doctype.'<br/>';
		echo $term.'<br/>';
		echo $comments.'<br/>';
		echo $difficulty.'<br/>';
		echo $completed.'<br/>';
		echo $id.'<br/>';
		echo '<br/>';
	}
	
	if($course_num == "") {
		echo 'You did not enter a course number. Try again.';
		exit(0);
	}
	
	//if(!is_int($course_num) || $course_num < 1) {
	//	echo 'You did not enter a proper integer. Try again.';
	//	exit(0);
	//}
	
	$ext = '.pdf';
	$middle = md5(time().$_SERVER['REMOTE_ADDR']);
	$end = $middle.$ext;
	$fn = $upload_path.$end;
	
	// Validate that we won't over-write an existing file
	if (file_exists($fn)) {
		echo 'The system encountered a file name that already exists. Try again.';
		exit(0);
	}
	
	// At this point, the files are ready to be concatenated. 
	$cmd = "/home2/uwthetax/pdftk/pdftk-1.41/pdftk/pdftk ";
	for($fnum = 0; $fnum < $numfiles; $fnum++) {
		if(!in_array($fnum, $empty)) {
			$form_name = 'userfile'.($fnum+1);
			$cmd .= $_FILES[$form_name]['tmp_name']." ";
		}		
	}
	$cmd .= 'cat output '.$fn;
	$output = passthru($cmd, $result);

	// Insert into documents here. 
	
	$query = "INSERT INTO test (username) VALUES ('username')";
	
	$sql = 'INSERT INTO documents (url, did, uid, year, cnum, type, term, comments, difficulty, completed) VALUES(
	"'.$middle.'",
	'.$course.',
	'.$id.',
	'.$year.',
	'.$course_num.',
	"'.$doctype.'",
	"'.$term.'",
	"'.$comments.'",
	'.$difficulty.',
	'.$completed.'
	)';
	$result = mysql_query($sql);
	if(!$result) {
		echo mysql_error();
		exit(0);
	}
	
	if($debug) {
		echo passthru('pwd');
		echo '<br/>The cmd command is '.$cmd.'<br/>';
		echo '<br/>';
		echo 'Your file upload was successful, view the file: ';
		echo '<a href=http://www.uwthetaxi.com/txscholar/pdf_server.php?file='.$fn.'>here</a>';
	}
		
	if(!$debug) {
		// Redirect 303. 
		//$status_code = 303;
		//header($status_code);
		header('Location: http://www.uwthetaxi.com/txscholar/pdf_upload_success.php?file='.$middle.'');
	}

?>