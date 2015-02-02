<h1>Your Profile</h1>
<?php
	br(1);
	writeln("This is the user profile page. In the future you will be able to edit more stuff.");
	br(1);
	write_header("My Book Library:", "2");
	include 'user_library.php';
?>