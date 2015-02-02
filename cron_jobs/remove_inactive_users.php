<?php 
// Cron job command:
// php -q public_html/txscholar/cron_jobs/remove_inactive_users.php

// Connect to DB.
define("MYSQL_HOST", "localhost");
define("MYSQL_USER", "user-name");
define("MYSQL_PASS", "password");
define("MYSQL_DB", "databse-name");
$conn = mysql_connect("".MYSQL_HOST."", "".MYSQL_USER."", "".MYSQL_PASS."") or die(mysql_error());
mysql_select_db("".MYSQL_DB."",$conn) or die(mysql_error());

// Remove users who have been inactive for a minute or longer. 
$sql = 'UPDATE user SET active = false WHERE last_activity < DATE_SUB(now(), INTERVAL 5 MINUTE)';
mysql_query($sql);
$sql = 'UPDATE cron_counter SET counter = counter + 1';
mysql_query($sql);
?>
