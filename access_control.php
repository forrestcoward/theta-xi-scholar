<?php // accesscontrol.php 

include_once 'data.php';
include_once 'common.php'; 
session_start();

$post_set = isset($_POST['uid']) && isset($_POST['pwd']);
$session_set = isset($_SESSION['uid']) && isset($_SESSION['pwd']);


$set = $post_set && $session_set;

if($set) { // No session or post variables.
	include $data["login_required_page_name"];
	exit; 
} else {
	
	$uid;
	$pwd;
	if($post_set) {
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];
	} else {
		$uid = $_SESSION['uid'];
	    $pwd = $_SESSION['pwd'];
	}
	
	$uid = strip_tags(clean($uid));
	$pwd = strip_tags(clean($pwd));
	$sql = 'SELECT * FROM user WHERE username = "'.$uid.'" AND password = "'.$pwd.'"';
	$result = mysql_query($sql); 
	
	if (mysql_num_rows($result) == 0) { 
		unset($_SESSION['uid']); 
		unset($_SESSION['pwd']); 
		include $data["access_denied_page_name"];
		exit; 
	}

	$active = mysql_result($result, 0, 'active');
	$id = mysql_result($result,0,'id');
	$username = mysql_result($result,0,'username'); 
	$notes = mysql_result($result,0,'notes');
	
	$authenticate = !$active && !$post_set;
	if($authenticate) {		
		unset($_SESSION['uid']); 
		unset($_SESSION['pwd']); 
		$sql = 'UPDATE user SET last_activity = now(), active = false WHERE username = "'.$username.'"';
		$result = mysql_query($sql);
		include $data["login_required_page_name"];
		exit;
	}
	
	$_SESSION['uid'] = $uid; 
	$_SESSION['pwd'] = $pwd;
	$sql = 'UPDATE user SET last_activity = now(), active = true WHERE username = "'.$username.'"';
	$result = mysql_query($sql);
}

 ?>

