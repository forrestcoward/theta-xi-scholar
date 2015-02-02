<?php include 'access_control.php'; ?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
		<title><?php echo $data["library_title"]; ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<script src="../txscholar/required_scripts/prototype_1.61.js" type="text/javascript"></script>
		<script src="../txscholar/required_scripts/scriptaculous.js" type="text/javascript"></script>
		<script type="text/javascript">var userid = "<?php echo $id; ?>";</script>
		<script src="book.js" type="text/javascript"></script>
		<script src="book_search_tools.js" type="text/javascript"></script>
		<script src="condensed_table_tools.js" type="text/javascript"></script>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen,projection" />
</head>
 
<body>

<div id="wrapper">
<div id="innerwrapper">

		<div id="header">
				<img src="<?= $data["website_banner"] ?>" alt="Website Banner Picture" /><br/>
				<h1><?= $data["website_header"] ?></h1>
				
				<ul id="nav">
					<?php generateNav($navbar, 2); ?>
				</ul>
				
				<ul id="subnav">
					<?php echo checkOnline(); ?>
				</ul> 
		</div>
		
		<?php
			include 'set_library_variables.php';
		?>
	
		<div id="sidebar">
		Library search allows queries on the book databases. 
		<h2>Specify Search:</h2>
		
		<form method="get" action="library.php">
			<div>
			<input type="radio" name="restriction" value="1" <?php if($restriction == 1) echo 'checked="checked"'; ?> />Books in Database<br/>
			<input type="radio" name="restriction" value="2" <?php if($restriction == 2) echo 'checked="checked"'; ?> />Books in Theta Xi<br/>
			<input type="radio" name="restriction" value="3" <?php if($restriction == 3) echo 'checked="checked"'; ?> />My Books<br/><br/>
			<hr />
			<input type="hidden" name="page" value="1" />
			<table>
			<tr><td><strong>ISBN:</strong></td><td><input type="text" name="isbn" value="<?=$isbn ?>" /></td></tr>
			<tr><td><strong>Title:</strong></td><td> <input type="text" name="title" value="<?=$title ?>" /><br/></td></tr>
			<tr><td><strong>Author:</strong></td><td> <input type="text" name="author" value="<?=$author ?>" /><br/></td></tr>
			<tr><td></td><td><input type="submit" value="Submit" /></td></tr>
			</table>
			<hr /><br/>
			Display Type:
			<br/>
			<select name="display" class='major_selection' size="1">
					<option value="full" <?php if($display == 'full') echo 'selected="true"'?>>Full Display</option>
					<option value="condensed" <?php if($display == 'condensed') echo 'selected="true"'?>>Condensed Display</option>
			</select>
			Order Results By:
			<br/>
			<select name="orderby" class='major_selection' size="1">
					<option value="none" <?php if($orderby == 'none') echo 'selected="true"'?> >No Ordering</option>
					<option value="title" <?php if($orderby == 'title') echo 'selected="true"'?> >Title</option>
					<option value="author" <?php if($orderby == 'author') echo 'selected="true"'?>>Author</option>
			</select>
			</div>
		</form>
		
		<p>
		<strong>Notes:</strong><br/>
		<strong>*</strong> Specifying an ISBN will limit results to 1 or 0 books.<br/>
		<strong>*</strong> Specifying no input will query all books in selection.<br/>
		</p>
	
		</div>
		
		<div id="contentnorightbar">
			<h1><?php echo $data["library_title"]; ?></h1>
			<?php include 'complete_book_search.php'; ?>
		</div>
		
		<div id="footer">
		 	<?php generateFooter(); ?>
		</div>
</div>
</div>


</body>
</html>