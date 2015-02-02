
<?php
	include 'data.php';
	include 'common.php';
	if(isset($_GET['file'])) {
		$file = $_GET['file'];
		$path = $data["upload_path"].$file.'.pdf';
		if (file_exists($path) && is_readable($path)) {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>Upload Successful</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="style.css" type="text/css" media="screen,projection" />
</head>
 
<body>
<div id="wrapper">
<div id="innerwrapper">
		<h1>Your upload was successful!</h1> <br />
		To upload another document click <a href="<?php echo $data["document_upload_url"]; ?>">here</a>.<br />
		To view your uploaded document click <a href='http://www.uwthetaxi.com/txscholar/pdf_server.php?file=<?php echo $file; ?>'>here</a>.<br />
</div>
</div>
</body>

</html>


<?php }} ?>