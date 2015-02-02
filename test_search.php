<?php include 'access_control.php'; ?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
		<title><?php echo $data["test_search_title"]; ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<script src="../txscholar/required_scripts/prototype_1.61.js" type="text/javascript"></script>
		<script src="../txscholar/required_scripts/scriptaculous.js" type="text/javascript"></script>
		<script type="text/javascript">var userid = "<?php echo $id; ?>";</script>
		<script src="../txscholar/test_search_tools.js" type="text/javascript"></script>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen,projection" />
</head>
 
<body>

<div id="wrapper">
<div id="innerwrapper">

		<div id="header">
				<img src="<?= $data["website_banner"] ?>" alt="Website Banner Picture" /><br/>
				<h1><?= $data["website_header"] ?></h1>
				
				<ul id="nav">
					<?php generateNav($navbar, 4); ?>
				</ul>
				
				<ul id="subnav">
					<?php echo checkOnline(); ?>
				</ul> 
		</div>
		
		<?php
			include 'set_test_variables.php';
		?>
	
		<div id="sidebar">
		Test Search allows queries on the test bank database:
		<h2>Specify Search:</h2>
		
		<form method="get" action="test_search.php">
			<div>
			<table>
			
			<tr><td><strong>Department:</strong></td></tr><tr><td><select id="department" type="text" class="major_selection" name="department" value="<?= $department ?>" /><?php include '../txscholar/web_services/limited_department_selector.php'; ?></select></td></tr>
			
		    <tr><td><strong>Class Number:</strong></td></tr><tr><td><select id="course_num" class="course_num_selection" type="text" name="course_num" value="" >
			</select></td></tr>
			
			<tr><td><input type="submit" value="Search" /></td></tr>
			
			</table>
			</div>
		</form>
		
		<p>
		<strong>Notes:</strong><br/>
		<strong>*</strong> Departments with no majors do not show up in the selection.<br/>
		</p>
	
		</div>
		
		<div id="contentnorightbar">
			<h1><?php echo $data["test_search_title"]; ?></h1>
			<?php 
				include 'complete_test_search.php';
			?>
		</div>
		
		<div id="footer">
		 	<?php generateFooter(); ?>
		</div>
</div>
</div>


</body>
</html>