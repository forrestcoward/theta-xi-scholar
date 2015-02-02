<?php
	// data.php, common.php included in here.
	include 'access_control.php'; 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?= $data["home_title"]?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script src="../txscholar/required_scripts/prototype_1.61.js" type="text/javascript"></script>
	<script src="../txscholar/required_scripts/scriptaculous.js" type="text/javascript"></script>
	<script src="book.js" type="text/javascript"></script>
	<script src="book_search_tools.js" type="text/javascript"></script>
	<script src="condensed_table_tools.js" type="text/javascript"></script>
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
		<ul id="nav"> <?php generateNav($navbar, 0); ?> </ul>				
		<ul id="subnav"> <? checkOnline() ?> </ul> 
	</div>
	
	<div id="sidebar">
		<!--<h2>Navigate Home Pages:</h2>-->
		<ul class="subnav"> <?php generatePageSubNav($homenav); ?> </ul>
	</div>
	
	<?php 
		// Get the requested page number.
		$val = 0;
		if(isset($_GET["page"])) {
			$page = $_GET["page"];
			$page = strip_html_tags(clean($page));
			if(is_numeric($page)) {
				if(is_int($page)) {
					$val = $page;
				} else {
					$val = intval($page);
				}
			} else {
				$val = 0;
			}
		}
		
		if($val >= count($homenav)/3) {
			$val = 0;
		}
	?>
	
	<div id="contentnorightbar">
				
		<?php 
			// Load the proper page based on the value of $var. 
			$include_path = $homenav[$val*3+2];
			include $include_path;
		?>
	</div>
	
	<div id="footer">
		<?php generateFooter(); ?>
	</div>
		
</div>
</div>
</body>
</html>