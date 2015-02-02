<?php 
session_start(); 
include 'data.php';
include 'common.php'; 
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title><?=$data["enter_web_title"]?></title>
		<link rel="stylesheet" href="enter_style.css" type="text/css" media="screen,projection" />
		<style type="text/css">
		</style>
	</head>
	<body>
	<div id="wrapper">
				<br/>
				<div> 
					<h1><?=$data["enter_title"]?></h1>
				</div>
				<br/>
				<div>
					<? checkOnlineEnterPage(); ?>
				</div>
				<br/>
				<div>
					<img src="<?=$data["tx_logo_name"]?>"/>
					<br/>
				</div>
				<br/>
				<div>
					<form method="post" action="<?=$data["home_url"]?>">
					<table id=logintable>
					<tr><td>Username:</td><td> <input type="text" size="10" maxlength="12" name="uid"></td></tr>
						<tr><td>Password:</td><td> <input type="password" size="10" maxlength="38" name="pwd"></td></tr>
						<tr><td colspan="2"><input type="submit" value="Submit" name="submit"><td></tr>
					</table>
					</form>
				</div>
				<br/>
		</div>
	</body>
</html>