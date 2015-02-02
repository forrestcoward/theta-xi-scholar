<?php include 'access_control.php'; ?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title><?= $data["book_search_title"]?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<script src="../txscholar/required_scripts/prototype_1.61.js" type="text/javascript"></script>
		<script src="../txscholar/required_scripts/scriptaculous.js" type="text/javascript"></script>
		<script type="text/javascript">var userid = "<?php echo $id; ?>";</script>
		<script src="book.js" type="text/javascript"></script>
		<script src="book_search_tools.js" type="text/javascript"></script>
		<script src="condensed_table_tools.js" type="text/javascript"></script>
		</script>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen,projection" />
</head>
 
<body>

<div id="wrapper">
<div id="innerwrapper">

		<div id="header">
				<img src="<?= $data["website_banner"] ?>"><br/>
				<h1><?= $data["website_header"] ?></h1>
				
				<ul id="nav">
					<?php generateNav($navbar, 1); ?>
				</ul>
				
				<ul id="subnav">
					<? checkOnline() ?>
				</ul> 
		</div>
		
		<div id="sidebar">	
				<h2>Recent Book Activity</h2>
				
				<?php
					getRecentBookActivity();
				?>		
		</div>
	
		<div id="contentnorightbar">
			
			<h1><?=$data["book_search_title"]?></h1>
			
			<p>Enter an ISBN to search for the corresponding book! If you the book is found you will have the option of adding it to your library.</p>
	
			<!-- ISBN Search. -->
			<div >
				<h3>ISBN Search</h3>
				ISBN: <input type="text" size="16" maxlength="16" id="isbn_text">
				<button id="isbn_button">Search</button>
			</div>
		
			<div id="loading" style="display:none">Searching...</div>
			
			<div id="book_info">
					<br/><strong>Please Enter an ISBN Number.</strong><br/><br/>
			</div>
			
			<div style="display:none" id="add_to_collection">
				<p id ="book_question"><button id="add_book">Yes, I own this book!</button></p>
			</div>
			
			<div>
				<?php 
					$link = href("http://www.uwthetaxi.com/txscholar/library.php?restriction=3&page=1&isbn=&title=&author=&display=full&orderby=none", "search");
					write_header("My Library (".$link.")", "3");
					include 'user_library.php';
				?>
			</div>
	
			<?php
			if($id == 1) { ?>
			<div>
				<h3>Mass ISBN Enter</h3>
				<textarea id="isbn_numbers" rows="10" cols="80"></textarea><br/>
				<button id="mass_enter">Enter ISBN Numbers</button></p>
			</div>
			<?php } ?>
			
		</div>
		
		<div id="footer">
		 	<?php generateFooter(); ?>
		</div>
		
</div>
</div>


</body>
</html>