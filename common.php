<?php // common.php 

include_once 'php_classes/TimeStamp.php';
include_once 'php_classes/TableBuilder.php'; 
include_once 'php_classes/HtmlUtils.php';
include_once 'php_classes/Book.php';

# Define MySQL Settings
define("MYSQL_HOST", "localhost");
define("MYSQL_USER", "uwthetax_txadmin");
define("MYSQL_PASS", "upsilon");
define("MYSQL_DB", "uwthetax_txscholar");

function connect_to_db() {
	$conn = mysql_connect("".MYSQL_HOST."", "".MYSQL_USER."", "".MYSQL_PASS."") or die(mysql_error());
	mysql_select_db("".MYSQL_DB."",$conn) or die(mysql_error());
}

connect_to_db();

function error($text) {
	echo $text;
	exit(0);
}

function getRecentBookActivity() {
	connect_to_db();
	$sql = "SELECT u.id, u.username, b.title, o.timestamp, b.isbn10
			FROM owns as o, user as u, books as b
			WHERE o.isbn13 = b.isbn13 and o.uid = u.id and o.owns = true
			ORDER BY o.timestamp DESC";
	
	$result = mysql_query($sql);
	$count = 0;
	while($array = mysql_fetch_array($result)) {
		if($count == 10) {
			break;
		}
				$ts = new TimeStamp($array[3]);
		$count++;
		$booklink = getBookLink($array[4], $array[2]);
		$userlink = getUserLink($array[1]);
		
		echo '<h3>';
		echo $ts->getDateStringWithoutYear();
		echo '</h3>: ';
		echo '<br/>';
		echo '<b>'.$userlink.'</b> added book <b>'.$booklink. '</b>.';
		echo '<br/>';
		echo '<br/>';
		echo '<hr>';
		echo '<br/>';
	}
}


// Prints out 'Please log in' if user is not logged in. Otherwise gives an option to log out.
function checkOnline() {
	if(isset($_SESSION['uid']) && isset($_SESSION['pwd'])) {
		$uid = $_SESSION['uid']; 
		$pwd = $_SESSION['pwd'];
		connect_to_db();
		$sql = "SELECT * FROM user WHERE username = '$uid' AND password = '$pwd' AND active = true"; 
		$result = mysql_query($sql); 
		if (mysql_num_rows($result) == 1) { ?>
			<li><p id="logout">You're logged in as <a href="home.php?page=1"><?php echo $uid;?>!</a>
			<a href="clear_session.php">Logout</a></p></li>
		<? } else { ?>
			<li><p id="logout"> Please sign in! </p></li>
		<? }
	} else { ?>
			<li><p id="logout"> Please sign in! </p></li>
	<? }
}

// Prints out 'Please log in' if user is not logged in. Otherwise gives an option to log out.
function checkOnlineEnterPage() {
	if(isset($_SESSION['uid']) && isset($_SESSION['pwd'])) {
		$uid = $_SESSION['uid']; 
		$pwd = $_SESSION['pwd'];
		connect_to_db();
		$sql = "SELECT * FROM user WHERE username = '$uid' AND password = '$pwd' AND active = true"; 
		$result = mysql_query($sql); 
		if (mysql_num_rows($result) == 1) { ?>
			<p id="logout">You're logged in as <a href="home.php"><?php echo $uid;?>!</a>
			<a href="clear_session.php">Logout</a></p>
		<? } else { ?>
			<p id="logout"> Please sign in! </p>
		<? }
	} else { ?>
		    <p id="logout"> Please sign in! </p>
	<? }
}

// Generates the navigation bar for the website. 
// @param navbar: contains the url and name of the url to print on the navigation bar.
// @param active_num: navigation item active_num is tagged with class "active" to signify the current page. 
function generateNav($navbar, $active_num) {
	for($i = 0; $i < count($navbar)/2; $i++) {
		if($i == $active_num) {
			echo '<li><a class="active" href="'.$navbar[$i*2].'">'.$navbar[$i*2+1].'</a></li>';
		} else {
			echo '<li><a href="'.$navbar[$i*2].'">'.$navbar[$i*2+1].'</a></li>';
		}
	}
}

// Generates the footer text for the website.
function generateFooter() {
	echo "<p>Any questions, comments, or suggestions? Talk to Forrest.</p>";
}

// Generates the sub navigation menu given the proper array for the page.
// Subnav can be thought of holding data tuples: (subnav page name, subnav full url)
function generatePageSubNav($subnav) {
	for($i = 0; $i < count($subnav)/3; $i++) {
		$j = $i*3;
		echo '<li><a href='.$subnav[$j+1].'><b>&raquo;</b>'.$subnav[$j].'</a></li>';
	}
}

// Generates an html table based on a single book. $array must have entries that match the schema of the book database.
function generateBookTable($array, $count) {

		$b = new Book($array);
		$image_tag = img($b->image_url, "Image Unavailable");
	
		$i = new TableBuilder(2, "inner_book_table");
		$inner = $i->
		begin()->
		td('ISBN13:', 'book_description')->
		td($b->isbn13, 'book_data')->
		td('ISBN10:', 'book_description')->
		td($b->isbn10, 'book_data')->
		td('Author:', 'book_description')->
		td($b->author, 'book_data')->
		td('Publisher:', 'book_description')->
		td($b->publisher, 'book_data')->
		td('Date:', 'book_description')->
		td($b->pubdate, 'book_data')->
		td('Edition:', 'book_description')->
		td($b->edition, 'book_data')->
		td('Pages:', 'book_description')->td($b->pages, 'book_data')->
		end();
		
		$booklink = getBookLink($b->isbn10, $b->title);
				
		$o = new TableBuilder(2, "outer_book_table");
		return $o->begin()->td($image_tag, "book_image")->td('<h2><strong>'.$count.'. '.$booklink.'</strong></h2><hr />'.$inner)->end();
}

function generateBookTableWithOwners($array, $count, $owns) {

		$b = new Book($array);
		$image_tag = img($b->image_url, "Image Unavailable");
		
		$names = "";
		$size = count($owns);
		for($i = 0; $i < $size; $i++) {
			$userlink = getUserLink($owns[$i]);
			if($i != $size-1) {
				$names .= $userlink.", ";
			} else {
				$names .= $userlink;
			}
		}
		
		$i = new TableBuilder(2, "inner_book_table");
		$inner = $i->begin()->td('ISBN13:', 'book_description')->td($b->isbn13, 'book_data')->td('ISBN10:', 'book_description')->td($b->isbn10, 'book_data')->td('Author:', 'book_description')->td($b->author, 'book_data')->td('Publisher:', 'book_description')->td($b->publisher, 'book_data')->td('Date:', 'book_description')->td($b->pubdate, 'book_data')->td('Edition:', 'book_description')->td($b->edition, 'book_data')->td('Pages:', 'book_description')->td($b->pages, 'book_data')->td('Owned By:', 'book_description')->td($names, 'book-data')->end();
		
		$booklink = getBookLink($b->isbn10, $b->title);
		
		$o = new TableBuilder(2, "outer_book_table");
		return $o->begin()->td($image_tag, "book_image")->td('<h2><strong>'.$count.'. '.$booklink.'</strong></h2><hr />'.$inner)->end();
}

function generateCondensedBookTableWithOwners($array, $count, $owns) {

		$names = "";
		$size = count($owns);
		for($i = 0; $i < $size; $i++) {
			$userlink = getUserLink($owns[$i]);
			if($i != $size-1) {
				$names .= $userlink.", ";
			} else {
				$names .= $userlink;
			}
		}
		
		$b = new Book($array);
		$image_tag = img($b->image_url, "Image Unavailable");
		
		$booklink = getBookLink($b->isbn10, $b->title);
		$table_entry = tr($b->isbn13, $b->title, $b->author, $names);
		return $table_entry;
}

function generateCondensedBookTable($array, $count, $fourth_row = false) {

		$b = new Book($array);
		$image_tag = img($b->image_url, "Image Unavilable");
		$booklink = getBookLink($b->isbn10, $b->title);
		
		$table_entry;
		if(!$fourth_row) {
			$table_entry = tr($b->isbn13, $b->title, $b->author);
		} else {
			$table_entry = tr($b->isbn13, $b->title, $b->author, "");
		}
		return $table_entry;
}

?>