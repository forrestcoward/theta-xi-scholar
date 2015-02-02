<?php
	// data.php, common.php included in here.
	include 'access_control.php'; 
?> 

<?php
	$username = "";
	if(isset($_GET["user"])) {
		$username = $_GET["user"];
		$username = strip_html_tags(clean($username));
	}
	
	$sql = "SELECT * FROM user WHERE username = '".$username."'";
	$result = mysql_query($sql); 
	
	$other_id = "";
	$other_username = "";
	$other_notes = "";
	$other_fname = "";
	$other_lname = "";
	$output = false;
	
	if (mysql_num_rows($result) != 0) { 
		$output = true;
		$other_id = mysql_result($result,0,'id');
		$other_username = mysql_result($result,0,'username'); 
		$other_notes = mysql_result($result,0,'notes');
		$other_fname = mysql_result($result, 0, 'fname');
		$other_lname = mysql_result($result, 0, 'lname');
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>Profile View</title>
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
		<ul id="nav"> <?php generateNav($navbar, 0); ?> </ul>				
		<ul id="subnav"> <? checkOnline() ?> </ul> 
	</div>
	
	<div id="sidebar">
		<!--<h2>Navigate Home Pages:</h2>-->
		<ul class="subnav"> <?php generatePageSubNav($homenav); ?> </ul>
	</div>
	
	
	<div id="contentnorightbar">
		<?php
			if($output == true) {
				write_header($other_username."'s Profile", '1');
				writeln('First Name: '.$other_fname);
				writeln('Last Name: '.$other_lname);
				writeln('Notes: '.$other_notes);
			}
		?>

	</div>
	
	<div id="footer">
		<?php generateFooter(); ?>
	</div>
		
</div>
</div>
</body>
</html>