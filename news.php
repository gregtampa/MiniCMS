<?php

include 'includes/header.php';
// Here we will check for Logged in team member and display content
// otherwise we will deny content

if ($loggedIn == 1) {
	
	// Function operatives
	if (isset($_GET['op'])) {
		$d = $_GET['op'];
	} elseif (isset($_POST['op'])) { // Forms
		$d = $_POST['op'];
	} else {
		$d = NULL;
	}
	
// Begin your content
function all() {
	/*
	 * Your first and primary function
	 * display's the landing page in which
	 * they arrive when coming to the module
	 * itself.
	 */

	echo '<h2>News</h2>';
	
	/*
	 * MySQL and MySQLi can be used to pull data and showsn in these modules
	 * a simple mysql statement to get data:
	 * $query = mysql_query("SELECT * FROM blogs ORDER BY postdate DESC") or die('Error: '. mysql_error() );
	 * once the query is established, assign variables
	 * // Assign variables
	 * $row = mysql_fetch_array($query);
	 * $this = $row['that'];
	 * echo '<p>'.$that.'</p>';
	 *
	 * You may also use SESSIONS and Directives from the includes/base.php or functions.php files
	 *
	*/
	$query = mysql_query("SELECT * FROM news ORDER BY pubdate DESC") or die('Error: '. mysql_error() );
	// Assign the variables
	while($row = mysql_fetch_array($query)){
		$id = $row['id'];
		$title = $row['title'];
		$content = $row['content'];
		$author = $row['author'];
		$news_date = date("F d, Y",strtotime($row['pubdate']));
		$news_time = date("H:i A",strtotime($row['pubdate']));
		
		// Display the data
		echo '<p><a href="news.php?op=read&id='.$id.'"><h2>'.$title.'</h2></a></p>';
    	echo '<p>'.$content.'</p>';
    	echo '<p><strong>Posted By:</strong> '.$author.' on '.$news_date.' at '.$news_time.'</p>';
    	echo '<hr>';
	}
	
// End the primary function
}

function read() {
	
	// Get the Story ID from all()
	$id = (int) $_GET['id'];
	
	// Now pull the data from the Database relating to that ID
	$query = mysql_query("SELECT * FROM news WHERE id='$id'") or die('Error: '. mysql_error() );
	
	// Now assign some variables
	$row = mysql_fetch_array($query);
	$id = $row['id'];
	$title = reverse_escape($row['title']);
	$content = reverse_escape($row['content']);
	$pub_date = date("F d, Y",strtotime($row['pubdate']));
	$pub_time = date("H:i A",strtotime($row['pubdate']));
	$author = $row['author'];
	
	// Armed with the variables's, let's display the data
	echo '<h2>'.$title.'</h2>';
	echo '<p>'.$content.'</p>';
	echo '<div><strong>Published by:</strong>&nbsp;'.$author.'&nbsp;on '.$pub_date.' at '.$pub_time.'</div>';
	
// End the read() function	
}

function del() {
	// Get the id variable
	$id = (int) $_GET['id'];
	$q1 = mysql_query("DELETE FROM news WHERE id='$id'")or die('Error: '. mysql_error() );

	
	if(!$q1) {
		echo '<p><b>Sorry! This News Title could not be deleted.</b></p>';
	}
	else {
		echo '<p><b>News Successfully Deleted.</b></p>';
	}
}
// Switch
// Used to control the operative IE: module.php?op=yourfunction
switch($d) {
	case 'read':
		read();
		break;
	case 'del':
		del();
		break;
	
	default:
		   all();
		   break;
}

// End the loggedIn if
}
// If they are not members of the site, tell them they must be to see it
elseif ($loggedIn == 0) {
?>

<div id="left">
	<div class="post">
		<h2>Sorry!</h2>
		<p>You must be a member of this site's dev team to see this content.</p>
	</div>
</div>
	
<?php

// End the elseif
}

// Display The Footer
include 'includes/footer.php';



?>
