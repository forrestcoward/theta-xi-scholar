
<?php 
// Cron job command:
// php -q public_html/txscholar/script.php

// Connect to DB.
define("MYSQL_HOST", "localhost");
define("MYSQL_USER", "uwthetax_txadmin");
define("MYSQL_PASS", "upsilon");
define("MYSQL_DB", "uwthetax_txscholar");
$conn = mysql_connect("".MYSQL_HOST."", "".MYSQL_USER."", "".MYSQL_PASS."") or die(mysql_error());
mysql_select_db("".MYSQL_DB."",$conn) or die(mysql_error());

// Remove users who have been inactive for a minute or longer. 
$sql = 'UPDATE user SET online = false WHERE last_activity < DATE_SUB(now(), INTERVAL 10 MINUTE)';
mysql_query($sql);
$sql = 'UPDATE cron_counter SET counter = counter + 1';
mysql_query($sql);
?>