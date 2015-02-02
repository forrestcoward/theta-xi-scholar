<?php include 'access_control.php'; ?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title><?= $data["statistics_title"]?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<script src="../txscholar/required_scripts/prototype_1.61.js" type="text/javascript"></script>
		<script src="../txscholar/required_scripts/scriptaculous.js" type="text/javascript"></script>
		<script type="text/javascript">var userid = "<?php echo id; ?>";</script>
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
					<?php generateNav($navbar, 5); ?>
				</ul>
				
				<ul id="subnav">
					<? checkOnline() ?>
				</ul> 
		</div>
		
		<div id="sidebar">
		
		
		</div>
	
		<div id="contentnorightbar">
			
			<h1><?=$data["statistics_title"]?></h1><br/>
			<p>This page is for statistics. It will show information such as the number of totals books in the database, the number of total books in theta xi, the person who owns the most books, the most owned book, the average number of books per user, the highest number of documents per class etc. 

		</div>
		
		<div id="footer">
		 	<?php generateFooter(); ?>
		</div>
		
</div>
</div>


</body>
</html>