<?php

// Connect to DB.
define("MYSQL_HOST", "localhost");
define("MYSQL_USER", "user-name");
define("MYSQL_PASS", "password");
define("MYSQL_DB", "databse-name");
$conn = mysql_connect("".MYSQL_HOST."", "".MYSQL_USER."", "".MYSQL_PASS."") or die(mysql_error());
mysql_select_db("".MYSQL_DB."",$conn) or die(mysql_error());

// Terminate the user session and return to enter page.
session_start();

if(isset($_SESSION['uid'])) {
	
	$uid = $_SESSION['uid'];
	$sql = 'UPDATE user SET active = false WHERE username = "'. $uid.'"';
	$result = mysql_query($sql);
}

unset($_SESSION['uid']);
unset($_SESSION['pwd']);
header('Location: http://www.uwthetaxi.com/txscholar/enter.php');
?>