<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head> 
		<title> Please Log In for Access </title> 
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
		<link rel="stylesheet" href="style.css" type="text/css" media="screen,projection" />
	</head> 
	<body> 
		<div id="wrapper">
		<div id="innerwrapper">
		<h1> Login Required </h1> 
		<p>You must log in to access this area of the site:</p> 
		<p><form method="post" action="<?=$_SERVER['PHP_SELF']?>"> 
		<table>
		<tr>
		<td>User ID:    </td><td> <input type="text" name="uid" size="8" /></td>
		</tr>
		<tr>
		<td>Password:    </td> <td><input type="password" name="pwd" SIZE="8" /></td>
		</tr>
		<tr>
		<td></td><td><input type="submit" value="Log In" /></td>
		</tr>
		</table>
		</form></p> 
		</div>
		</div>
	</body> 
</html> 