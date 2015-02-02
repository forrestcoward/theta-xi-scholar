<?php

include '../common.php';
include '../data.php';

$isbn = $_POST["isbn"];
$userid = $_POST["userid"];

$sql = 'DELETE FROM owns WHERE isbn13 = "'.$isbn.'" and uid = "'.$userid.'"';
echo $sql;
$result = mysql_query($sql);

?>