<?php

function write_header($string, $header) {
	echo '<h'.$header.'>'.$string.'</h'.$header.'>';
	echo '<br/>';
}

function writeln($string) {
	echo $string;
	echo '<br/>';
}

function br($j) {
	for($i = 0; $i < $j; $i++) {
		echo '<br/>';
	}
}

/* Returns an html img tag given the src and alt attributes. */
function img($src, $alt) {
	return '<img src="'.$src.'" alt="'.$alt.'"/>';
}

/* Takes a variable number of string arguments and creates a table 
 * row string with each element as a table data. */
function tr() {
	$td_array = func_get_args();
	$result = '<tr>';
	for($i = 0; $i < count($td_array); $i++) {
		$result .= '<td>';
		$result .= $td_array[$i];
		$result .= '</td>';
	}
	$result .= '</tr>';
	return $result;
}

/* Returns an html a tag given the url and display name. */
function href($url, $display) {
	return '<a href="'.$url.'">'.$display.'</a>';
}


/* Given a proper user name, returns html that links to that user's profile. */
function getUserLink($username) {
	$url = 'http://www.uwthetaxi.com/txscholar/view.php?user='.$username;
	return href($url, $username);
}

/* Given a proper ISBN10, returns html that links to a webpage with more detail on that book. */
function getBookLink($isbn, $title) {
	$url = 'http://www.lookupbyisbn.com/itemDetail.aspx?type=Books&id='.$isbn;
	return href($url, $title);
}

/* Echos the green checkmark image for the todo list page. */
function greenCheck() {
	echo '<img src="../txscholar/images/smallestcheck.gif" alt="Check" />';
}

/* Remove HTML tags, including invisible text such as style and
 * script code, and embedded objects.  Add line breaks around
 * block-level tags to prevent word joining after tag removal. */
function strip_html_tags($text) {
    $text = preg_replace(
        array(
             // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
             // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
    return strip_tags( $text );
}

/* Prevents SQL injection by escaping potentially bad user input.
 * Requires a database connection. */
function clean($string) {
	if(get_magic_quotes_gpc()) { // prevents duplicate backslashes
    	$string = stripslashes($string);
    }
    if (phpversion() >= '4.3.0') {
    	$string = mysql_real_escape_string($string);
    }
    else {
    	$string = mysql_escape_string($string);
    }
    return $string;
}

?>